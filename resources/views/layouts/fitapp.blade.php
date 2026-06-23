<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2e91b8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    @auth
        <meta name="fitapp-user-id" content="{{ auth()->id() }}">
    @endauth
    <title>@yield('title', 'FitApp')</title>
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="icon" href="{{ asset('fitapp/img/pwa-icon-192.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('fitapp/img/pwa-icon-192.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- CSS GLOBAL DE LA APP --}}
    <link rel="stylesheet" href="{{ asset('fitapp/css/app.css') }}">

    @stack('styles')
</head>
<body class="@yield('body_class')">
    <div class="connection-status" id="connectionStatus" role="status" aria-live="polite" hidden>
        <i class="bi bi-cloud-slash"></i>
        <span>Sin conexion. Tu avance se guardara en este dispositivo.</span>
    </div>
    <div class="app-shell">
        <main class="app-page">
            @yield('content')
        </main>

        @hasSection('bottom_nav')
            @yield('bottom_nav')
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        const queueKey = 'fitapp_workout_queue_v1';
        const userId = Number(document.querySelector('meta[name="fitapp-user-id"]')?.content || 0);
        const status = document.getElementById('connectionStatus');

        function readQueue() {
            try { return JSON.parse(localStorage.getItem(queueKey) || '[]'); }
            catch (error) { return []; }
        }

        function writeQueue(queue) {
            localStorage.setItem(queueKey, JSON.stringify(queue));
            updateStatus();
        }

        function pendingCount() {
            return readQueue().filter(item => Number(item.user_id) === userId).length;
        }

        function updateStatus(syncing) {
            if (!status || !userId) return;
            const pending = pendingCount();
            status.hidden = navigator.onLine && pending === 0 && !syncing;
            status.classList.toggle('is-online', navigator.onLine);
            const icon = status.querySelector('i');
            const text = status.querySelector('span');

            if (!navigator.onLine) {
                icon.className = 'bi bi-cloud-slash';
                text.textContent = pending
                    ? pending + (pending === 1 ? ' cambio pendiente. Se sincronizara al volver la conexion.' : ' cambios pendientes. Se sincronizaran al volver la conexion.')
                    : 'Sin conexion. Tu avance se guardara en este dispositivo.';
            } else if (syncing || pending) {
                icon.className = 'bi bi-arrow-repeat';
                text.textContent = 'Sincronizando tu avance...';
            }
        }

        function queueWorkout(item) {
            const queue = readQueue();
            const identity = item.url + '|' + item.progress_key + '|' + userId;
            const next = queue.filter(entry => (entry.url + '|' + entry.progress_key + '|' + entry.user_id) !== identity);
            next.push(Object.assign({}, item, { user_id: userId, queued_at: new Date().toISOString() }));
            writeQueue(next);
        }

        async function sync() {
            if (!navigator.onLine || !userId || pendingCount() === 0) {
                updateStatus(false);
                return;
            }

            updateStatus(true);
            try {
                const contextResponse = await fetch(@json(route('fitapp.sync-context')), {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin',
                    cache: 'no-store'
                });
                if (!contextResponse.ok) throw new Error('Sesion no disponible');
                const context = await contextResponse.json();
                if (Number(context.user_id) !== userId) return;

                const snapshot = readQueue().filter(item => Number(item.user_id) === userId);
                for (const item of snapshot) {
                    const response = await fetch(item.url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': context.csrf_token
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(item.payload)
                    });
                    if (!response.ok) throw new Error('No se pudo sincronizar');
                    const current = readQueue();
                    writeQueue(current.filter(entry => entry.queued_at !== item.queued_at));
                }
                window.dispatchEvent(new CustomEvent('fitapp:synced'));
            } catch (error) {
                updateStatus(false);
            }
            updateStatus(false);
        }

        window.FitappOffline = { queueWorkout, sync, pendingCount, updateStatus };
        window.addEventListener('online', sync);
        window.addEventListener('offline', () => updateStatus(false));
        document.addEventListener('DOMContentLoaded', () => { updateStatus(false); sync(); });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js?v=3', { updateViaCache: 'none' }).catch(() => {}));
        }

        document.addEventListener('submit', function (event) {
            if (!event.target.matches('form[action$="/logout"]')) return;
            localStorage.removeItem(queueKey);
            navigator.serviceWorker?.controller?.postMessage({ type: 'CLEAR_PRIVATE' });
        });
    })();
    </script>
    @stack('scripts')
</body>
</html>

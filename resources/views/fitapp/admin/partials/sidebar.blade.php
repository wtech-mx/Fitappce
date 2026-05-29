<aside class="admin-sidebar">
    <div class="admin-brand">
        <div class="admin-brand-title">FitCoach Admin</div>
    </div>

    <nav class="admin-nav">
        <a href="{{ route('fitapp.admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            Dashboard
        </a>

        <a href="{{ route('fitapp.admin.citas') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.citas') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            Citas
        </a>

        <a href="{{ route('fitapp.admin.usuarios') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.usuarios*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            Usuarios
        </a>

        <a href="{{ route('fitapp.admin.planes') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.planes*') ? 'active' : '' }}">
            <i class="bi bi-clipboard2-pulse-fill"></i>
            Planes
        </a>

        <a href="{{ route('fitapp.admin.mediciones') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.mediciones*') ? 'active' : '' }}">
            <i class="bi bi-rulers"></i>
            Mediciones
        </a>

        <a href="{{ route('fitapp.admin.rutinas') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.rutinas*') ? 'active' : '' }}">
            <i class="bi bi-activity"></i>
            Rutinas
        </a>

        <a href="{{ route('fitapp.admin.ejercicios') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.ejercicios*') ? 'active' : '' }}">
            <i class="bi bi-collection-play-fill"></i>
            Ejercicios
        </a>

        <a href="{{ route('fitapp.admin.evidencias') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.evidencias') ? 'active' : '' }}">
            <i class="bi bi-camera-video-fill"></i>
            Evidencias
        </a>

        <a href="{{ route('fitapp.admin.nutricion') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.nutricion*') ? 'active' : '' }}">
            <i class="bi bi-journal-medical"></i>
            Nutrición
        </a>

        <a href="{{ route('fitapp.admin.pagos') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.pagos') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i>
            Pagos
        </a>

        <a href="{{ route('fitapp.admin.configuracion') }}" class="admin-nav-link {{ request()->routeIs('fitapp.admin.configuracion') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>
            Configuración
        </a>
        <a href="{{ route('fitapp.dashboard') }}" class="admin-nav-link">
            <i class="bi bi-phone-fill"></i>
            Vista usuario
        </a>

        <form method="POST" action="{{ route('fitapp.logout') }}" class="m-0">
            @csrf
            <button type="submit" class="admin-nav-link admin-nav-button w-100">
            <i class="bi bi-box-arrow-right"></i>
            Salir
            </button>
        </form>
    </nav>

    <div class="mt-auto pt-2">
        <div class="surface-card p-3 bg-transparent border-0" style="background:rgba(255,255,255,.06)!important;">
            <div class="small text-white-50 mb-1">Coach activo</div>
            <div class="fw-bold text-white">Carlos Coach</div>
            <div class="small text-white-50">Rutinas + nutrición</div>
        </div>
    </div>
</aside>

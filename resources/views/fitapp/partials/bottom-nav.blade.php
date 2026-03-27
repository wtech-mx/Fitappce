<nav class="bottom-nav">
    <div class="row text-center g-0">
        <div class="col">
            <a href="{{ route('fitapp.dashboard') }}" class="{{ request()->routeIs('fitapp.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i>
                Inicio
            </a>
        </div>

        <div class="col">
            <a href="{{ route('fitapp.rutina') }}" class="{{ request()->routeIs('fitapp.rutina') ? 'active' : '' }}">
                <i class="bi bi-activity"></i>
                Rutina
            </a>
        </div>

        <div class="col">
            <a href="{{ route('fitapp.nutricion') }}" class="{{ request()->routeIs('fitapp.nutricion') || request()->routeIs('fitapp.plan') || request()->routeIs('fitapp.recetas') ? 'active' : '' }}">
                <i class="bi bi-cup-hot"></i>
                Nutrición
            </a>
        </div>

        <div class="col">
            <a href="{{ route('fitapp.progreso') }}" class="{{ request()->routeIs('fitapp.progreso') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i>
                Progreso
            </a>
        </div>

        <div class="col">
            <a href="{{ route('fitapp.perfil') }}" class="{{ request()->routeIs('fitapp.perfil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                Perfil
            </a>
        </div>
    </div>
</nav>

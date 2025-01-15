@extends('template.main')
@extends('components.style')

@section('title', 'Barging')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="text-center mb-4">Barging</h2>

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="dashboard-container">
                    <!-- Over Burden Section -->
                    <div class="section-card">
                        <h3 class="section-title">Actual & Plan</h3>
                        <div class="metrics-grid">
                            <div class="metric">
                                <a href="{{ route('indexPlan') }}" class="cardcost text-decoration-none">
                                <h4>Plan</h4>
                                    <div class="percentage-box">
                                        <strong></strong> <span>  {{ number_format($planNominal, 0, ',', '.') }}</span>
                                    </div>
                                </a>
                            </div>
                            <div class="metric">
                                <a href="{{ route('indexmenu') }}" class="cardcost text-decoration-none">
                                <h4>Actual</h4>
                                <div class="percentage-box">
                                    <strong></strong> <span> {{ number_format($quantity, 0, ',', '.') }}</span>

                                    </div>
                                </a>
                            </div>
                            <div class="metric">
                                <h4>Deviasi</h4>
                                <div class="percentage-box">
                                    <strong></strong> <span>{{ number_format($deviasi, 0, ',', '.') }}</span>

                                    </div>
                            </div>
                            <div class="metric">
                                <h4>Percentage</h4>
                                <div class="percentage-box">
                                    <strong></strong> <span>{{ number_format($percen, 0, ',', '.') }}%</span>

                                    </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
.container-fluid {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    font-size: 1.8rem;
    color: #388e3c;
    font-weight: bold;
}

.dashboard-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.section-card {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    flex: 1 1 45%;
    max-width: 500px;
}

.section-title {
    font-size: 1.5rem;
    color: #388e3c;
    text-align: center;
    margin-bottom: 15px;
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    text-align: center;
}

.metric {
    background-color: #388e3c;
    color: #ffffff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
}

.metric h4 {
    font-size: 1rem;
    margin-bottom: 10px;
}

.metric p {
    font-size: 1.2rem;
    font-weight: bold;
}

@media (max-width: 768px) {
    .section-card {
        flex: 1 1 100%;
    }

    .metrics-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection
@section('scripts')
@endsection

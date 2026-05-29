@extends('layouts.member')

@section('title', 'Pilih Personal Trainer')

@push('styles')
<style>
    .page-header { margin-bottom: 2rem; }
    .page-header h1 {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        color: #fff;
        line-height: 1.15;
        margin-bottom: 4px;
    }
    .page-header p { color: var(--text-muted); font-size: 0.9rem; }

    /* Alerts */
    .alert-custom {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
    }
    .alert-ok   { background: rgba(34,197,94,0.10);  border: 1px solid rgba(34,197,94,0.22);  color: #86efac; }
    .alert-err  { background: rgba(239,68,68,0.10);  border: 1px solid rgba(239,68,68,0.22);  color: #fca5a5; }
    .alert-warn { background: rgba(245,158,11,0.10); border: 1px solid rgba(245,158,11,0.22); color: #fcd34d; }

    .btn-new {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: linear-gradient(135deg, var(--accent), #fb923c);
        color: #0f172a;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.875rem;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        white-space: nowrap;
        border: none;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.15s;
    }
    .btn-new:hover { opacity: 0.88; transform: scale(1.02); color: #0f172a; }

    .step-card {
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .step-header {
        background: rgba(255,255,255,0.03);
        border-bottom: 1px solid var(--border);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff;
    }
    .step-badge {
        background: var(--accent);
        color: #0f172a;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .step-body {
        padding: 1.5rem;
    }

    /* PT Card */
    .pt-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1rem;
    }
    .pt-card {
        background: rgba(255,255,255,0.03);
        border: 2px solid var(--border);
        border-radius: 14px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .pt-card:hover { border-color: rgba(245,158,11,0.3); transform: translateY(-3px); }
    .pt-card.selected { border-color: var(--accent); background: rgba(245,158,11,0.05); }

    .pt-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(99,102,241,0.15);
        color: #818cf8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0 auto 1rem;
        font-family: 'Syne', sans-serif;
    }
    .pt-name {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff;
        margin-bottom: 5px;
    }

    /* Package Card */
    .pkg-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem;
    }
    .pkg-card {
        background: rgba(255,255,255,0.03);
        border: 2px solid var(--border);
        border-radius: 14px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .pkg-card:hover { border-color: rgba(245,158,11,0.3); transform: translateY(-3px); }
    .pkg-card.selected { border-color: var(--accent); background: rgba(245,158,11,0.05); }

    .pkg-sessions {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 2.5rem;
        color: var(--accent);
        line-height: 1;
        margin-bottom: 2px;
    }
    .pkg-name {
        font-weight: 700;
        color: #fff;
        font-size: 1.05rem;
        margin-bottom: 10px;
    }
    .pkg-price {
        color: #4ade80;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 4px;
    }

    /* Summary */
    .summary-table td { padding: 10px 0; color: #e2e8f0; border-bottom: 1px solid var(--border); }
    .summary-table tr:last-child td { border-bottom: none; }
</style>
@endpush

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>Personal Trainer</h1>
            <p>Pilih personal trainer dan paket latihan sesuai kebutuhan Anda</p>
        </div>
        @if($activeSub)
        <a href="{{ route('member.pt.my-subscription') }}" class="btn-new">
            <i class="feather-calendar"></i> Lihat Langganan Aktif
        </a>
        @endif
    </div>

    {{-- ALERT: Sudah punya langganan --}}
    @if($activeSub)
    <div class="alert-custom alert-warn mb-4">
        <i class="feather-alert-circle fs-4"></i>
        <div>
            <strong>Anda sudah memiliki langganan PT aktif</strong> bersama
            <strong>{{ $activeSub->coach->name }}</strong>
            (Paket: {{ $activeSub->package->name }} · Status: {{ $activeSub->status_label }}).
            <br>Selesaikan atau batalkan dulu sebelum daftar PT lagi.
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="alert-custom alert-ok"><i class="feather-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-custom alert-err"><i class="feather-x-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- LANGKAH 1: Pilih PT --}}
    <div class="step-card">
        <div class="step-header">
            <div class="step-badge">1</div>
            Pilih Personal Trainer
        </div>
        <div class="step-body">
            <div class="pt-grid">
                @forelse($personalTrainers as $pt)
                <div class="pt-card" id="card_pt_{{ $pt->id }}" onclick="selectPT({{ $pt->id }}, '{{ addslashes($pt->name) }}')">
                    <div class="pt-avatar">{{ substr($pt->name, 0, 1) }}</div>
                    <div class="pt-name">{{ $pt->name }}</div>
                    <span style="font-size:0.75rem; background:rgba(255,255,255,0.06); padding:3px 8px; border-radius:4px; color:var(--text-muted); display:inline-block; margin-bottom:8px;">Personal Trainer</span>
                    <div class="text-muted" style="font-size:0.8rem;"><i class="feather-phone me-1"></i>{{ $pt->phone_number ?? '-' }}</div>
                </div>
                @empty
                <div class="text-center py-4 text-muted w-100" style="grid-column: 1/-1;">
                    <i class="feather-user-x d-block mb-2 fs-2 opacity-25"></i>
                    Belum ada Personal Trainer yang tersedia.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- LANGKAH 2: Pilih Paket --}}
    <div class="step-card">
        <div class="step-header">
            <div class="step-badge">2</div>
            Pilih Paket Sesi
        </div>
        <div class="step-body">
            <div class="pkg-grid">
                @forelse($packages as $pkg)
                <div class="pkg-card" id="card_pkg_{{ $pkg->id }}" onclick="selectPackage({{ $pkg->id }}, '{{ addslashes($pkg->name) }}', {{ $pkg->price }})">
                    <div class="pkg-sessions">{{ $pkg->session_count }}</div>
                    <div class="text-muted" style="font-size:0.75rem; letter-spacing:1px; margin-bottom:8px;">SESI</div>
                    <div class="pkg-name">{{ $pkg->name }}</div>
                    <div style="font-size:0.75rem; background:rgba(255,255,255,0.06); padding:3px 8px; border-radius:4px; display:inline-block; margin-bottom:10px;">{{ $pkg->duration_minutes }} menit/sesi</div>
                    <div class="pkg-price">Rp {{ number_format($pkg->price, 0, ',', '.') }}</div>
                </div>
                @empty
                <div class="text-center py-4 text-muted w-100" style="grid-column: 1/-1;">
                    <i class="feather-package d-block mb-2 fs-2 opacity-25"></i>
                    Belum ada paket PT tersedia.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- LANGKAH 3: Ringkasan --}}
    <div class="step-card" id="summaryCard" style="display:none;">
        <div class="step-header" style="background: rgba(245,158,11,0.05); color: var(--accent);">
            <div class="step-badge">3</div>
            Konfirmasi Pendaftaran
        </div>
        <div class="step-body">
            <div class="row align-items-center">
                <div class="col-md-8 mb-3 mb-md-0">
                    <table class="w-100 summary-table">
                        <tr>
                            <td width="150" class="text-muted">Personal Trainer</td>
                            <td id="summaryPT" class="fw-bold">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Paket</td>
                            <td id="summaryPkg" class="fw-bold">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Harga</td>
                            <td id="summaryPrice" class="fw-bold text-success">-</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-warning" style="font-size:0.85rem;"><i class="feather-info me-1"></i> Pembayaran dilakukan di administrasi gym saat sesi pertama</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-md-end text-center">
                    <form action="{{ route('member.pt.register') }}" method="POST" id="registerForm">
                        @csrf
                        <input type="hidden" name="coach_id" id="selectedPTInput">
                        <input type="hidden" name="pt_package_id" id="selectedPkgInput">
                        <button type="submit" class="btn-new" style="font-size:1rem; padding:12px 24px; width:100%; justify-content:center;" id="registerBtn" disabled onclick="return confirm('Daftar PT ini? Pembayaran dilakukan di admin.')">
                            <i class="feather-check-circle"></i> DAFTAR SEKARANG
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
let selectedPTId = null, selectedPTName = null;
let selectedPkgId = null, selectedPkgName = null, selectedPkgPrice = null;

function selectPT(id, name) {
    selectedPTId = id;
    selectedPTName = name;
    document.getElementById('selectedPTInput').value = id;

    document.querySelectorAll('.pt-card').forEach(c => c.classList.remove('selected'));
    document.getElementById(`card_pt_${id}`).classList.add('selected');

    updateSummary();
}

function selectPackage(id, name, price) {
    selectedPkgId = id;
    selectedPkgName = name;
    selectedPkgPrice = price;
    document.getElementById('selectedPkgInput').value = id;

    document.querySelectorAll('.pkg-card').forEach(c => c.classList.remove('selected'));
    document.getElementById(`card_pkg_${id}`).classList.add('selected');

    updateSummary();
}

function updateSummary() {
    const summaryCard = document.getElementById('summaryCard');
    const registerBtn = document.getElementById('registerBtn');

    if (selectedPTId && selectedPkgId) {
        summaryCard.style.display = 'block';
        document.getElementById('summaryPT').textContent = selectedPTName;
        document.getElementById('summaryPkg').textContent = selectedPkgName;
        document.getElementById('summaryPrice').textContent = 'Rp ' + selectedPkgPrice.toLocaleString('id-ID');
        registerBtn.disabled = false;
        summaryCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        summaryCard.style.display = 'none';
        registerBtn.disabled = true;
    }
}
</script>
@endpush

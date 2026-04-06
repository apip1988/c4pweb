<div class="tab-pane fade {{ (isset($active) && $active) ? 'show active' : '' }}" id="{{ $id }}">
    <div class="detail-card animate__animated animate__fadeIn">
        <span class="detail-label">Nama Penuh</span>
        <span class="detail-value" style="color: #3051a0;">{{ $n }}</span>
        
        <span class="detail-label">Pangkat / Unit</span>
        <span class="detail-value">{{ $r }}</span>
        
        <span class="detail-label">Jawatan dan Gred</span>
        <span class="detail-value" style="color: #555;">{{ $g }}</span>
        
        <span class="detail-label">E-mel Rasmi</span>
        <span class="detail-value"><a href="mailto:{{ $e }}" class="text-primary font-italic">{{ $e }}</a></span>
        
        <span class="detail-label">No. Telefon Sambungan</span>
        <span class="detail-value font-weight-bold">{{ $t }}</span>
    </div>
</div>
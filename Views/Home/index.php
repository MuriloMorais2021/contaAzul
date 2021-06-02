<h1>DashBoard</h1>
<div class="db-row">
    <dib class="grid-1">
        <div class="db-grid-area">
            <div class="db-grid-area-count"><?=$products_sold;?></div>
            <div class="db-grid-area-legend">Produtos Vendidos</div>
        </div>
    </dib>
    <dib class="grid-1">
        <div class="db-grid-area">
            <div class="db-grid-area-count">R$ <?=number_format($revenue, 2, ',', '.');?></div>
            <div class="db-grid-area-legend">Receitas</div>
        </div>
    </dib>
    <dib class="grid-1">
        <div class="db-grid-area">
            <div class="db-grid-area-count">R$ <?=number_format($expenses, 2, ',', '.');?></div>
            <div class="db-grid-area-legend">Despesas</div>
        </div>
    </dib>
</div>

<div class="db-row">
    <div class="grid-2">
        <div class="db-info">
            <div class="db-info-title">
                Despesas e Receitas dos ultimos 30 dias 
            </div>
            <div class="db-info-body" style="height: 350px;">
                <canvas id="rel1"></canvas>
            </div>
        </div>
    </div>
    <div class="grid-1">
        <div class="db-info">
            <div class="db-info-title">
                Status de Pgto.
            </div>
            <div class="db-info-body" style="height: 350px;">
                <canvas id="rel2" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="section-header">
    <h2><i class="bi bi-receipt"></i> Historial de Compras</h2>
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Buscar compras...">
    </div>
</div>

<div class="purchases-container">
    <?php if (!empty($compras)): ?>
        <?php foreach ($compras as $compra): ?>
            <div class="purchase-card">
                <div class="purchase-header">
                    <span class="purchase-id">Orden #<?= $compra['order_id'] ?></span>
                    <span class="purchase-date"><?= date('d M Y', strtotime($compra['purchase_date'])) ?></span>
                    <span class="purchase-status <?= strtolower($compra['status']) ?>"><?= $compra['status'] ?></span>
                </div>

                <div class="purchase-details">
                    <div class="purchase-games">
                        <?php foreach ($compra['items'] as $item): ?>
                            <div class="purchase-game">
                                <img src="<?= $item['image'] ?>" alt="<?= esc($item['title']) ?>" class="game-image">
                                <div class="game-info">
                                    <h4><?= esc($item['title']) ?></h4>
                                    <span class="game-price">$<?= $item['price'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="purchase-summary">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>$<?= number_format($compra['subtotal'], 2) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Impuestos:</span>
                            <span>$<?= number_format($compra['tax'], 2) ?></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span>$<?= number_format($compra['total'], 2) ?></span>
                        </div>

                        <button class="view-receipt-btn">Ver recibo</button>
                        <?php if ($compra['status'] == 'COMPLETED'): ?>
                            <button class="download-btn">
                                <i class="bi bi-download"></i> Descargar
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="bi bi-cart-x"></i>
            <p>No tienes compras registradas</p>
            <a href="<?= base_url('todos') ?>" class="browse-btn">Explorar juegos</a>
        </div>
    <?php endif; ?>
</div>
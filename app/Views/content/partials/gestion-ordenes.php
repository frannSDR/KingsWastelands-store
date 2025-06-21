<div class="admin-sales-container">
    <!-- header -->
    <div class="sales-header">
        <h2><i class="bi bi-graph-up"></i> Gestion de Ventas</h2>
    </div>

    <!-- resumen de estadisticas -->
    <?php
    $ventasTotales = 0;
    $operaciones = is_array($compras) ? count($compras) : 0;
    $copiasVendidas = 0;
    if ($operaciones > 0) {
        foreach ($compras as $compra) {
            $ventasTotales += floatval($compra['total']);
            foreach ($compra['productos'] as $producto) {
                $copiasVendidas += $producto['cantidad'];
            }
        }
    }
    ?>
    <div class="sales-stats">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="bi bi-cart-check"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Recaudado</span>
                <span class="stat-value">$<?= number_format($ventasTotales, 2) ?></span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon count">
                <i class="bi bi-receipt"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Ventas Realizadas</span>
                <span class="stat-value"><?= $operaciones ?></span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon count">
                <i class="bi bi-receipt"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Copias Vendidas</span>
                <span class="stat-value"><?= $copiasVendidas ?></span>
            </div>
        </div>
    </div>

    <!-- tabla de ventas -->
    <div class="sales-table-container">
        <table class="sales-table">
            <thead>
                <tr>
                    <th>ID <i class="bi bi-arrow-down-up"></i></th>
                    <th>Fecha <i class="bi bi-arrow-down-up"></i></th>
                    <th>Usuario</th>
                    <th>Nombre Facturacion</th>
                    <th>Productos</th>
                    <th>Total <i class="bi bi-arrow-down-up"></i></th>
                    <th>Estado</th>
                    <th>Método</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compras as $compra): ?>
                    <tr>
                        <td>#<?= $compra['compra_id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($compra['fecha'])) ?></td>
                        <td>
                            <div class="customer-info">
                                <span class="customer-name"><?= esc($compra['user_nickname']) ?></span>
                                <span class="customer-email"><?= esc($compra['user_email']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="customer-info">
                                <span class="customer-name"><?= esc($compra['nombre_completo']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="products-info">
                                <span class="product-count"><?= count($compra['productos']) ?> producto<?= count($compra['productos']) > 1 ? 's' : '' ?></span>
                                <div class="product-tooltip">
                                    <?php foreach ($compra['productos'] as $producto): ?>
                                        <div class="product-item">
                                            <span><?= esc($producto['nombre']) ?></span>
                                            <span><?= $producto['cantidad'] ?> × $<?= number_format($producto['precio_unitario'], 2) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </td>
                        <td>$<?= number_format($compra['total'], 2) ?></td>
                        <td>
                            <span class="status-badge <?= strtolower($compra['estado']) ?>">
                                <?= $compra['estado'] ?>
                            </span>
                        </td>
                        <td>
                            <span class="payment-method">
                                <?= esc($compra['metodo_pago']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view-btn" title="Ver detalles" data-compra='<?= json_encode($compra) ?>'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- paginacion -->
    <div id="ventasPagination-container" class="ventas-pagination">
        <?php
        $start = max(1, $currentVentasPage - 2);
        $end = min($totalVentasPages, $currentVentasPage + 2);
        $baseUrl = base_url('/admin-section/admin-ventas');
        ?>
        <?php if ($start > 1): ?>
            <button class="ventas-pagination-button <?= 1 == $currentVentasPage ? 'active' : '' ?>">
                <a href="<?= $baseUrl ?>?ventas_page=1">1</a>
            </button>
            <?php if ($start > 2): ?>
                <span class="ventas-pagination-ellipsis">...</span>
            <?php endif; ?>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <button class="ventas-pagination-button <?= $i == $currentVentasPage ? 'active' : '' ?>">
                <a href="<?= $baseUrl ?>?ventas_page=<?= $i ?>"><?= $i ?></a>
            </button>
        <?php endfor; ?>

        <?php if ($end < $totalVentasPages): ?>
            <?php if ($end < $totalVentasPages - 1): ?>
                <span class="ventas-pagination-ellipsis">...</span>
            <?php endif; ?>
            <button class="ventas-pagination-button <?= $totalVentasPages == $currentVentasPage ? 'active' : '' ?>">
                <a href="<?= $baseUrl ?>?ventas_page=<?= $totalVentasPages ?>"><?= $totalVentasPages ?></a>
            </button>
        <?php endif; ?>
    </div>
</div>

<!-- modal de detalles de las ventas -->
<div id="sale-detail-modal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detalles de Venta <span id="sale-id"></span></h3>
        </div>
        <div class="modal-body">
            <div class="sale-detail-section">
                <h4><i class="bi bi-person"></i> Información del Cliente</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Nombre:</span>
                        <span class="detail-value" id="modal-nombre"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value" id="modal-email"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Teléfono:</span>
                        <span class="detail-value" id="modal-telefono"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">ID de Cliente:</span>
                        <span class="detail-value" id="modal-userid"></span>
                    </div>
                </div>
            </div>

            <div class="sale-detail-section">
                <h4><i class="bi bi-cart"></i> Productos</h4>
                <div class="products-detail-list" id="modal-productos">
                    <div class="product-detail-item">
                        <div class="product-info">
                            <span class="product-name"></span>
                            <span class="product-platform">PC</span>
                        </div>
                        <div class="product-pricing">
                            <span class="product-quantity"></span>
                            <span class="product-price">$</span>
                        </div>
                    </div>
                </div>

                <div class="sale-totals" id="modal-totales">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span>$</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total:</span>
                        <span>$</span>
                    </div>
                </div>
            </div>

            <div class="sale-detail-section">
                <h4><i class="bi bi-credit-card"></i> Información de Pago</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Método: </span>
                        <span class="detail-value" id="modal-metodo"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">ID de Transacción: </span>
                        <span class="detail-value" id="modal-transaccion"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Estado: </span>
                        <span class="detail-value status-badge completed" id="modal-estado"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Fecha: </span>
                        <span class="detail-value" id="modal-fecha"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn secondary-btn close-modal">Cerrar</button>
        </div>
    </div>
</div>
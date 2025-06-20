<div class="section-header">
    <h2><i class="bi bi-cart-check-fill"></i> Gestión de Compras</h2>
    <div class="header-actions">
        <div class="search-filter">
            <input type="text" id="search-orders" placeholder="Buscar compras...">
            <select id="filter-status">
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendiente</option>
                <option value="completado">Completado</option>
                <option value="cancelado">Cancelado</option>
                <option value="reembolsado">Reembolsado</option>
            </select>
        </div>
    </div>
</div>

<?php if ($errors = session('error-msg')): ?>
    <?php foreach ((array)$errors as $msg): ?>
        <div class="alert alert-danger"><?= esc($msg) ?></div>
    <?php endforeach; ?>
<?php elseif (session('exito-msg')): ?>
    <div class="alert alert-success">
        <?= session('exito-msg') ?>
    </div>
<?php endif; ?>

<!-- Tabla de compras -->
<div class="admin-table-container">
    <table class="purchase-admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Productos</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Método Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($compras as $compra): ?>
                <tr data-status="<?= strtolower($compra['estado']) ?>">
                    <td>#<?= $compra['compra_id'] ?></td>
                    <td>
                        <div class="user-info">
                            <span class="user-name"><?= esc($compra['usuario_nombre']) ?></span>
                            <span class="user-email"><?= esc($compra['usuario_email']) ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="products-list">
                            <?php foreach (json_decode($compra['productos'], true) as $producto): ?>
                                <div class="product-item">
                                    <span class="product-name"><?= esc($producto['nombre']) ?></span>
                                    <span class="product-qty">x<?= $producto['cantidad'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </td>
                    <td>$<?= number_format($compra['total'], 2) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($compra['fecha_compra'])) ?></td>
                    <td>
                        <span class="status-badge <?= strtolower($compra['estado']) ?>">
                            <?= $compra['estado'] ?>
                        </span>
                    </td>
                    <td><?= $compra['metodo_pago'] ?></td>
                    <td>
                        <div class="action-buttons">
                            <button data-id="<?= $compra['compra_id'] ?>" class="btn-icon btn-view" title="Ver detalles">
                                <i class="bi bi-eye"></i>
                            </button>
                            <?php if ($compra['estado'] == 'Pendiente'): ?>
                                <button data-id="<?= $compra['compra_id'] ?>" class="btn-icon btn-complete" title="Marcar como completado">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            <?php endif; ?>
                            <?php if (in_array($compra['estado'], ['Pendiente', 'Completado'])): ?>
                                <button data-id="<?= $compra['compra_id'] ?>" class="btn-icon btn-cancel" title="Cancelar compra">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            <?php endif; ?>
                            <?php if ($compra['estado'] == 'Completado'): ?>
                                <button data-id="<?= $compra['compra_id'] ?>" class="btn-icon btn-refund" title="Reembolsar">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para ver detalles de compra -->
<div id="order-details-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detalles de Compra #<span id="modal-order-id"></span></h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <div class="order-details-section">
                <h4>Información del Cliente</h4>
                <div class="detail-row">
                    <span class="detail-label">Nombre:</span>
                    <span id="client-name" class="detail-value"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span id="client-email" class="detail-value"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Teléfono:</span>
                    <span id="client-phone" class="detail-value"></span>
                </div>
            </div>

            <div class="order-details-section">
                <h4>Productos</h4>
                <div id="products-details" class="products-details">
                    <!-- Productos se cargarán aquí -->
                </div>
                <div class="order-totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="total-row">
                        <span>Descuentos:</span>
                        <span id="discounts">-$0.00</span>
                    </div>
                    <div class="total-row">
                        <span>Envío:</span>
                        <span id="shipping">$0.00</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total:</span>
                        <span id="total">$0.00</span>
                    </div>
                </div>
            </div>

            <div class="order-details-section">
                <h4>Información de Pago</h4>
                <div class="detail-row">
                    <span class="detail-label">Método:</span>
                    <span id="payment-method" class="detail-value"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Transacción:</span>
                    <span id="transaction-id" class="detail-value"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Estado:</span>
                    <span id="payment-status" class="detail-value"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary close-modal">Cerrar</button>
            <button id="print-invoice" class="btn btn-primary">
                <i class="bi bi-printer"></i> Imprimir Factura
            </button>
        </div>
    </div>
</div>
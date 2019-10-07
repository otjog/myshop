<!-- Modal -->
<div class="modal fade" id="productBasketModal" tabindex="-1" role="dialog" aria-labelledby="productBasketModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Сколько добавим в корзину?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('_kp.modules.shop.basket._elements.modal_body')
            </div>
        </div>
    </div>
</div>
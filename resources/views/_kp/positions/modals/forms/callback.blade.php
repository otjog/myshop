<div class="modal fade" id="callbackForm" tabindex="-1" role="dialog" aria-labelledby="callbackTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="callbackTitle">Обратный звонок</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" name="callback" action="{{route('sendmessage')}}">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">
                            Имя
                            <input type="text" class="form-control" name="name" placeholder="Укажите ваше имя" required>
                        </label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">
                            Телефон
                            <input type="text" class="form-control" name="phone" placeholder="Укажите ваш контактный телефон" required>
                        </label>
                    </div>
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-12 pt-0">Удобный способ связи:</legend>
                            <div class="col-sm-12">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="callType" value="phone" checked>
                                        Звонок
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="callType" value="Viber">
                                        Viber
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="callType" value="WhatsApp">
                                        WhatsApp
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="callType" value="Telegram">
                                        Telegram
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="callType" value="Skype">
                                        Skype
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <input type="hidden" name="orderType" value="Обратный звонок">
                    <input type="hidden" name="orderFrom" value="<a href='{{Request::fullUrl()}}'>Страница отправки</a>">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary px-4">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>
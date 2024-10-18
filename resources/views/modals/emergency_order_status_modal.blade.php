<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ translate('Choose an order status') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" name="order_id" id="order_id" value="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="update_delivery_status">{{ translate('Order Status') }}</label>
                    <select class="form-control" id="update_delivery_status">
                        <option value="pending">{{ translate('Pending') }}</option>
                        <option value="on_the_way">{{ translate('On The Way') }}</option>
                        <option value="completed">{{ translate('Completed') }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">{{ translate('Arrival Minutes') }}</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="minutes" name="minutes" value="">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">{{ translate('minutes') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="update_emergency_order_status()">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title uppercase font-bold" id="rejectModalLabel" style="color:#545454;">Reason For Rejection</h3>
            </div>
            <form id="reject_form" method="post" action="{{ route('fte_request.status_update') }}">
                <div class="modal-body text-black">
                    @csrf
                    <input type="hidden" class="form-control" name="id" id="id" value="{{isset($data)?$data->id:''}}">
                    <div class="ml-0 mt-2">
                        <label for="" class="block text-black font-medium  text-sm uppercase">Enter the reason</label>
                        <input type="text" name="reason" required class="form-control text-black focus:text-black  border-gray-300 rounded"/>
                    </div>
                    <div class=" modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn dropdown-color saveReject">Send</button>
                    </div>
                </div>    
            </form>
        </div>
    </div>
</div>

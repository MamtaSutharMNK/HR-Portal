<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-black uppercase font-bold" id="rejectModalLabel">Reason For
                    Rejection</h1>
                
            </div>
            <form id="reject_form" method="post" enctype="multipart/form-data">
                <div class="modal-body text-black">
                    @csrf
                    @method('post')
                    <input type="hidden" class="form-control" name="id" id="id" value="{{isset($data)?$data->id:''}}">
               
                    <div class="ml-0 mt-2">
                        <label for="" class="block text-black font-medium  text-sm uppercase">Reason for Reject</label>
                        <input type="text" name="reason" required
                               class="form-control text-black focus:text-black  border-gray-300 rounded"/>
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="submit" class="btn btn-primary bg-primary saveReject">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
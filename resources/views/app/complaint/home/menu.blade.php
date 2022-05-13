<div class="list-group list-group-transparent mb-0 mail-inbox pb-3">
    <div class="mt-4 mx-4 mb-4 text-center">
        <a onClick="saveNew()" class="btn btn-primary btn-lg d-grid">Buat Komplain</a>
    </div>
    <a href="/complaint/inbox" class="list-group-item d-flex align-items-center {{ ($menu == 'inbox') ? 'active' : '' }} mx-4">
        <span class="icons"><i class="ri-mail-line"></i></span> Inbox
        <span class="ms-auto badge bg-secondary bradius hide" style="display: none;">14</span>
    </a>
    <a href="/complaint/drafts" class="list-group-item d-flex align-items-center {{ ($menu == 'drafts') ? 'active' : '' }} mx-4">
        <span class="icons"><i class="ri-mail-open-line"></i></span> Drafts
    </a>
    <a href="/complaint/starred" class="list-group-item d-flex align-items-center {{ ($menu == 'starred') ? 'active' : '' }} mx-4">
        <span class="icons"><i class="ri-star-line"></i></span> Starred
    </a>
    <a href="/complaint/sent" class="list-group-item d-flex align-items-center {{ ($menu == 'sent') ? 'active' : '' }} mx-4">
        <span class="icons"><i class="ri-mail-send-line"></i></span> Sent Mail
    </a>
    <a href="/complaint/trash" class="list-group-item d-flex align-items-center {{ ($menu == 'trash') ? 'active' : '' }} mx-4">
        <span class="icons"><i class="ri-delete-bin-line"></i></span> Trash
    </a>
</div>

@if (!empty($is_detail))
    @if (!empty($data->complaint_user_resolve) && count($data->complaint_user_resolve) > 0)
    <div class="card-body border-top p-0 py-3">
        <div class="list-group list-group-transparent mb-0 mail-inbox mx-4">
            User yang memproses komplain ini :
            @foreach($data->complaint_user_resolve as $key => $val)
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-2">
                    <span class="w-3 h-3 brround bg-primary me-2"></span>
                    {{ $val->user->name }} ({{ $val->created_at }})
                </a>
            @endforeach
        </div>
    </div>
    @endif
@endif

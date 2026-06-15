<!-- Show Modal -->
<div class="modal fade" id="showCategory{{ $category->id }}" tabindex="-1" aria-labelledby="showCategoryLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h1 class="modal-title fs-5 text-white" id="showCategoryLabel{{ $category->id }}">Category Details</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> {{ $category->name }}</p>
                <p><strong>Description:</strong> {{ $category->desc }}</p>
                <p>
                    <strong>Status:</strong>
                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

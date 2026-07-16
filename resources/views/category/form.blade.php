<div class="mb-3">
    <label class="form-label">Category Name *</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}">
    @error('name')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Status *</label>
    <select name="status" class="form-select">
        <option value="active" {{ (old('status', $category->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
        <option value="in-active" {{ (old('status', $category->status ?? '') == 'in-active') ? 'selected' : '' }}>Inactive
        </option>
    </select>
    @error('status')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

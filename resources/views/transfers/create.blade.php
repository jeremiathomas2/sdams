@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Membership / <span>New Transfer</span></div>
<div class="page-header">
    <div>
        <h2>🔄 New Transfer Request</h2>
        <p>Initiate a new membership transfer</p>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif

<div class="card">
    <form action="{{ route('transfers.store') }}" method="POST">
        @csrf
        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Member</label>
                <select name="member_id" class="form-control" required>
                    <option value="">Select Member</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->full_name }} ({{ $member->member_id }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Transfer Type</label>
                <select name="type" id="transferType" class="form-control" required>
                    <option value="Out" {{ old('type', 'Out') == 'Out' ? 'selected' : '' }}>Transfer Out (Leaving this church)</option>
                    <option value="In" {{ old('type') == 'In' ? 'selected' : '' }}>Transfer In (Joining this church)</option>
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">From Church</label>
                <div class="combobox" id="fromCombobox" data-locked="false">
                    <input type="text" name="from_church" class="form-control" placeholder="e.g. Central SDA Church" autocomplete="off" required value="{{ old('from_church') }}">
                    <svg class="combobox-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    <div class="combobox-list"></div>
                </div>
                <div class="combobox-lock-hint" style="display:none">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Locked to this church (leaving)
                </div>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">To Church</label>
                <div class="combobox" id="toCombobox" data-locked="false">
                    <input type="text" name="to_church" class="form-control" placeholder="e.g. Riverside SDA Church" autocomplete="off" required value="{{ old('to_church') }}">
                    <svg class="combobox-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    <div class="combobox-list"></div>
                </div>
                <div class="combobox-lock-hint" style="display:none">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Locked to this church (joining)
                </div>
            </div>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Request Date</label>
            <input type="date" name="request_date" class="form-control" value="{{ old('request_date', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Notes/Reason</label>
            <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('transfers.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Submit Request</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const churches = @json($churches);
        const thisChurch = @json($thisChurch);

        const typeSelect = document.getElementById('transferType');
        const fromRoot = document.getElementById('fromCombobox');
        const toRoot = document.getElementById('toCombobox');
        const fromInput = fromRoot.querySelector('input');
        const toInput = toRoot.querySelector('input');

        const norm = s => String(s || '').trim().toLowerCase();
        const escapeHtml = s => String(s).replace(/[&<>"']/g, c => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        }[c]));

        function available(root) {
            const other = root === fromRoot ? toInput : fromInput;
            const otherVal = other.value.trim();
            const self = root.querySelector('input');
            const lockedVal = self.readOnly ? self.value.trim() : '';

            return churches.filter(name => {
                const n = norm(name);
                if (otherVal !== '' && n === norm(otherVal)) return false;
                if (lockedVal !== '' && n === norm(lockedVal)) return false;
                return true;
            });
        }

        function renderList(root) {
            const input = root.querySelector('input');
            const list = root.querySelector('.combobox-list');
            const query = input.value.trim();

            let items = available(root);
            if (query !== '') {
                items = items.filter(name => norm(name).includes(norm(query)));
            }

            const exact = items.some(name => norm(name) === norm(query));
            const isNew = query !== '' && !exact;

            if (items.length === 0 && !isNew) {
                list.innerHTML = '<div class="combobox-empty">No churches found</div>';
                list.classList.add('open');
                return;
            }

            let html = '';
            items.forEach(name => {
                html += '<div class="combobox-item" data-value="' + escapeHtml(name) + '">' +
                    '<svg class="combobox-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 10a8 8 0 0 1 16 0c0 4.5-3 7-6 9h-4c-3-2-6-4.5-6-9z"/><circle cx="12" cy="10" r="2.5"/></svg>' +
                    escapeHtml(name) + '</div>';
            });
            if (isNew) {
                html += '<div class="combobox-item add' + (items.length === 0 ? ' highlighted' : '') + '" data-value="' + escapeHtml(query) + '">' +
                    '<svg class="combobox-item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>' +
                    'Add &quot;' + escapeHtml(query) + '&quot; as new church</div>';
            }

            list.innerHTML = html;
            list.classList.add('open');

            if (!isNew || items.length > 0) {
                const first = list.querySelector('.combobox-item');
                if (first) first.classList.add('highlighted');
            }
        }

        function closeAll() {
            document.querySelectorAll('.combobox-list.open').forEach(l => l.classList.remove('open'));
        }

        function selectItem(root, value) {
            const input = root.querySelector('input');
            input.value = value;
            root.querySelector('.combobox-list').classList.remove('open');
            handleCrossField(root);
        }

        function handleCrossField(root) {
            const input = root.querySelector('input');
            const otherRoot = root === fromRoot ? toRoot : fromRoot;
            const otherInput = otherRoot.querySelector('input');

            if (input.value.trim() !== '' && norm(input.value) === norm(otherInput.value)) {
                otherInput.value = '';
                renderList(otherRoot);
                showToast('Transfer', 'From and To church must be different', 'info');
            }

            renderList(otherRoot);
        }

        function setLocked(root, locked, label) {
            const input = root.querySelector('input');
            const hint = root.querySelector('.combobox-lock-hint');

            input.readOnly = locked;
            root.dataset.locked = locked ? 'true' : 'false';

            if (locked && thisChurch !== '') {
                input.value = thisChurch;
                hint.style.display = 'inline-flex';
            } else {
                input.value = '';
                hint.style.display = 'none';
            }

            if (label) hint.innerHTML = label;
        }

        function applyType() {
            const type = typeSelect.value;
            const lockOutHint = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Locked to this church (leaving)';
            const lockInHint = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Locked to this church (joining)';

            if (type === 'Out') {
                setLocked(fromRoot, thisChurch !== '', lockOutHint);
                setLocked(toRoot, false);
            } else {
                setLocked(toRoot, thisChurch !== '', lockInHint);
                setLocked(fromRoot, false);
            }

            if (norm(fromInput.value) === norm(toInput.value)) {
                (type === 'Out' ? toInput : fromInput).value = '';
            }

            renderList(fromRoot);
            renderList(toRoot);
        }

        typeSelect.addEventListener('change', applyType);

        [fromRoot, toRoot].forEach(root => {
            const input = root.querySelector('input');
            input.addEventListener('input', () => renderList(root));
            input.addEventListener('focus', () => renderList(root));
            input.addEventListener('change', () => handleCrossField(root));
            input.addEventListener('keydown', e => {
                const list = root.querySelector('.combobox-list');
                const items = Array.from(list.querySelectorAll('.combobox-item'));

                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (items.length === 0) { renderList(root); return; }
                    let idx = items.findIndex(i => i.classList.contains('highlighted'));
                    if (e.key === 'ArrowDown') idx = (idx + 1) % items.length;
                    else idx = (idx - 1 + items.length) % items.length;
                    items.forEach(i => i.classList.remove('highlighted'));
                    items[idx].classList.add('highlighted');
                    items[idx].scrollIntoView({ block: 'nearest' });
                } else if (e.key === 'Enter') {
                    const highlighted = list.querySelector('.combobox-item.highlighted');
                    if (highlighted) {
                        e.preventDefault();
                        selectItem(root, highlighted.dataset.value);
                    }
                } else if (e.key === 'Escape') {
                    list.classList.remove('open');
                }
            });
        });

        document.addEventListener('click', e => {
            const item = e.target.closest('.combobox-item');
            if (item) {
                const root = item.closest('.combobox');
                selectItem(root, item.dataset.value);
                return;
            }
            if (!e.target.closest('.combobox')) closeAll();
        });

        applyType();
    })();
</script>
@endpush

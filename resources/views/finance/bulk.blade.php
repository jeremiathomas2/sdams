@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Finance <span>/ Bulk CSV Upload</span></div>
<div class="page-header">
    <div>
        <h2>📤 Bulk CSV Upload</h2>
        <p>Upload multiple offering records using a CSV file</p>
    </div>
</div>

<div class="card">
    <div style="max-width:600px;margin:0 auto;text-align:center;padding:40px 20px;">
        <div style="width:64px;height:64px;background:rgba(26,86,160,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        </div>
        <h3 class="card-title">Select CSV File</h3>
        <p class="card-sub" style="margin-bottom:24px">Download the <a href="#" style="color:var(--primary);font-weight:600">CSV Template</a> to ensure your data is formatted correctly before uploading.</p>
        
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="border:2px dashed var(--border);border-radius:12px;padding:40px;margin-bottom:24px;cursor:pointer;" onclick="document.getElementById('csv_file').click()">
                <input type="file" id="csv_file" name="csv_file" style="display:none" accept=".csv">
                <p style="color:var(--text-muted)">Click to browse or drag and drop your CSV file here</p>
            </div>
            <button type="button" class="btn btn-primary-solid" style="width:100%" onclick="showToast('Upload','Bulk upload functionality coming soon...','info')">Upload and Process</button>
        </form>
    </div>
</div>
@endsection

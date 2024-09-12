@props(['attachments'])
@props(['project'])

<!-- Attachment Card -->
<div class="col-md-12">
    <div class="card info-card revenue-card">
        <div class="card-body">
            <h5 class="card-title">Attachment <span>| (max:5MB)</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/attachement_.webp') }}" alt="icon" class="card-icon rounded-circle p-2">
                </div>
                <div class="ps-3 mx-5">
                    @foreach($attachments as $attachment)
                        <div class="attachment-container position-relative">
                            @php
                                $extension = pathinfo($attachment->path, PATHINFO_EXTENSION);
                            @endphp

                            <div class="attachment-box">
                                @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                    <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $attachment->path) }}" alt="Attachment" class="img-thumbnail" style="max-width: 200px;">
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank" style="margin-right: 3rem;">{{ $attachment->original_name }}</a>
                                @endif
                            </div>
                            <div class="delete-button-wrapper">
                                <form action="/project/{{ $project->id }}/delete-attachment" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="attachment_path" value="{{ $attachment->path }}">
                                    @can('edit', $project)
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-x"></i> <!-- Bootstrap Icons for the cross icon -->
                                        </button>
                                    @endcan
                                </form>
                            </div>
                        </div>
                    @endforeach
                    <div>
                        <span class="text-success small pt-1 fw-bold">
                            <form id="uploadForm" action="/project/{{ $project->id }}/attachments" method="POST" enctype="multipart/form-data" onsubmit="return validateUploadForm()">
                                @csrf
                                @method('POST')
                                <div class="row mb-3 col-md-12">
                                    <div class="col-md-12 d-flex">
                                        @can('edit', $project)
                                            <input type="file" name="attachments[]" multiple class="form-control" id="file-upload">
                                            <button class="btn btn-primary btn-sm" type="submit">Upload</button>
                                        @endcan
                                    </div>
                                </div>
                            </form>
                            <script>
                                function validateUploadForm() {
                                    const fileInput = document.getElementById('file-upload');
                                    if (fileInput.files.length === 0) {
                                        alert('Please select at least one file to upload.');
                                        return false; // Prevent form submission
                                    }
                                    return true; // Allow form submission
                                }
                            </script>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- End attachment Card -->

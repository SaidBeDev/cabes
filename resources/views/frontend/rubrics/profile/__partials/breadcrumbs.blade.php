{{-- <!-- Row -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
        </nav>
    </div>
</div>
<!-- /Row -->
 --}}
@if (count($breadcrumbs))

    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)

                        @if ($breadcrumb->url && !$loop->last)
                            <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                        @else
                            <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                        @endif

                    @endforeach
                </ol>
            </nav>
        </div>
    </div>

@endif

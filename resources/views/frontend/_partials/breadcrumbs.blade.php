<div class="breadcrumbs-wrap">
    {{-- <h1 class="breadcrumb-title">{{ $data['title'] }}</h1> --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ isset($title) ? $title : $data['title'] }}</li>
        </ol>
    </nav>
</div>

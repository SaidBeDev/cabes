
@extends('backend.layouts.master')

@section('content')
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Nouveau Contact</h5>
            {!! Form::open([
                'method' => 'POST',
                'url' => route('backend.contact.store')
            ]) !!}

                @if ($errors->any())
                    <div class="form-row">
                        <div class="alert alert-danger">

                            <div class="col-xl-12">
                                <div class="col-xl-6">
                                    <div class="uk-alert uk-alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

                <div class="form-row">

                    <div class="col-md-4">
                        <label for="">Type de Contact</label>
                        <select name="contact_type_id" class="form-control selectpicker" >
                            <option name="" value="" selected>Non spécifié</option>
                            @foreach ($data['contact_types'] as $type)
                                <option name="contact_type_id"  value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="validationCustom05">Contenu</label>
                        <input type="text" name="content" class="form-control" id="validationCustom05" placeholder="" required="">
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Enregistrer</button>

                {!! Form::close() !!}
        </div>
    </div>
@endsection


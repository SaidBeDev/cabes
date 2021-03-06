@php
    $contact = $data['contact'];
@endphp

@extends('backend.layouts.master')

@section('content')
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Modifier le Contact</h5>
            {!! Form::open([
                'method' => 'PUT',
                'url' => route('backend.contact.update', ['id' => $contact->id])
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
                        <select name="contact_type_id" class="form-control selectpicker" disabled>
                            <option name="contact_type_id" value="{{ $contact->contact_type->id }}">{{ $contact->contact_type->name }}</option>
                        </select>
                       {{-- <option name="contact_type_id" value="{{ $contact->contact_type->id }}">{{ $contact->contact_type->name }}</option  --}}
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="validationCustom05">Contenu</label>
                        <input type="text" name="content" class="form-control" value="{{ $contact->content }}" placeholder="" required="">
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Enregistrer</button>

                {!! Form::close() !!}
        </div>
    </div>
@endsection


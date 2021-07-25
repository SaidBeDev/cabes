
@php
    $article = $data['article'];
@endphp

@extends('frontend.layouts.master')

@section('content')

    <!-- ========================== About Facts List Section =============================== -->
    <section class="pt-0 mb-5">
        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="list_facts_wrap">
                        <div class="sec-heading mb-3">
                            <h2>{!! $article->name !!}</h2>
                        </div>


                        <div class="about">
                            <p class="fs-17">
                                {{ $article->desc }}
                            </p>
                        </div>
                        {{-- <div class="list_facts">
                            <div class="list_facts_icons"><i class="ti-desktop"></i></div>
                            <div class="list_facts_caption">
                                <h4>Nemo enim ipsam voluptatem quia.</h4>
                                <p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure</p>
                            </div>
                        </div> --}}

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="list_facts_wrap_img">

                        <img src="{{ asset(config('SaidTech.images.about.upload_path') . $article->image) }}" class="img-fluid" alt="" />

                    </div>
                </div>

            </div>

            <div class="row about mt-5">
                <div class="col-md-12">
                    <div>
                        <p class="fs-17">
                           {{ $article->detail }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ========================== About Facts List Section =============================== -->

@endsection
 @section('styles')
     <style>
         .about p {
            color: #333;
            font-weight: 600;
         }
         .list_facts_wrap {
             max-width: unset;
         }
     </style>
 @endsection

@extends('front.v1.layouts.basic')

@section('container')

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">{{$message}}</h1>
                                    <p class="mb-4">&nbsp;</p>
                                </div>
                                <form class="user">
                                    <div class="form-group">
                                        &nbsp;
                                    </div>
                                    <a href="/" class="btn btn-primary btn-user btn-block">
                                        &nbsp;
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection


@section('page_script')

    <script type="text/javascript">
        $(document).ready(function(){


        });
    </script>

@endsection
@extends('adminlte::page')

@section('title', 'Configurações ')

@section('content_header')
    <h1>Configurações do site</h1>
@endsection

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                <h5><i class="icon fas fa-ban"></i>Ocorreu um erro.</h5>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-success">
            {{session('warning')}}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('settings.save') }}" method="POST" class="form-horizontal">
                @method('PUT')
                @csrf

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Logo </label>
                    <div class="col-sm-10">
                        <input type="text" name="logo" value="{{ $settings['logo'] }}" class="form-control" />
                    </div>
                </div> 

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Título do site </label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="{{ $settings['title'] }}" class="form-control" />
                    </div>
                </div> 

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Sub-título do site </label>
                    <div class="col-sm-10">
                        <input type="text" name="subtitle" value="{{$settings['subtitle']}}" class="form-control" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> E-mail contato </label>
                    <div class="col-sm-10">
                        <input type="email" name="email" value="{{$settings['email']}}" class="form-control" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Endereço </label>
                    <div class="col-sm-10">
                        <input type="text" name="endereco" value="{{$settings['endereco']}}" class="form-control" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Telefone </label>
                    <div class="col-sm-10">
                        <input type="text" name="telefone" value="{{$settings['telefone']}}" class="form-control" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Cor do background </label>
                    <div class="col-sm-1">
                        <input type="color" name="bgcolor" value="{{$settings['bgcolor']}}" class="form-control" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Cor Título</label>
                    <div class="col-sm-1">
                        <input type="color" name="colortitle" value="{{$settings['colortitle']}}" class="form-control" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Cor do Subtitulo </label>
                    <div class="col-sm-1">
                        <input type="color" name="colorsubtitle" value="{{$settings['colorsubtitle']}}" class="form-control" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Cor do texto </label>
                    <div class="col-sm-1">
                        <input type="color" name="textcolor" value="{{$settings['textcolor']}}" class="form-control" />
                    </div>
                </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <input type="submit" value="Salvar" class="btn btn-success" />
                            </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
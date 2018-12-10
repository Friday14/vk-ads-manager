@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-content-center">
            @include('partials.alert')

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ $ad->name }}
                    </div>
                    <form action="{{ route('ads.update', $ad) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Примечание</label>
                                <textarea name="note" class="form-control">{{ $ad->note }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit">Сохранить</button>
                                <a class="btn btn-danger btn-sm" href="{{ route('campaigns.show', $ad->campaign) }}">Назад</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
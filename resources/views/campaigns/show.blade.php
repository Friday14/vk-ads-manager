@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('partials.alert')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Информация о выбраном кабинете</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-text">
                                    {{ $campaign->cabinet->name }} / {{ $campaign->name }}
                                </h4>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <a href="{{ route('cabinets.show', $campaign->cabinet) }}">
                                        К списку кампаний >>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5 class="card-title">Список объявлений</h5>
                        <div class="row">
                            @forelse($campaign->ads as $ad)
                                <div class="col-md-6 col-lg-6">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <b>{{ $ad->name }}</b>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    Формат: <b>{{ $ad->presentFormat() }}</b>
                                                </li>
                                                <li>
                                                    Тип оплаты: <b>{{ $ad->presentCostType() }}</b>
                                                </li>
                                                @if($ad->isCostConversion())
                                                    <li>
                                                        Цена за переход: <b>{{ $ad->presentCpc() }} ₽</b>
                                                    </li>
                                                @else
                                                    <li>
                                                        Цена за 1000 показов: <b>{{ $ad->presentCpm() }} ₽</b>
                                                    </li>
                                                @endif
                                                <li>
                                                    Дата запуска (utc): <b>{{ $ad->start_time ?? 'Не задано'}} </b>
                                                </li>
                                                <li>
                                                    Дата остановки (utc): <b>{{ $ad->stop_time ?? 'Не задано'}}</b>
                                                </li>
                                                <li>
                                                    Дневной лимит объявлений: <b>{{ $ad->day_limit ?? 'Не задан'}} ₽</b>
                                                </li>
                                                <li>
                                                    Общий лимит: <b>{{ $ad->day_limit ?? 'Не задан'}} ₽</b>
                                                </li>
                                                <li>
                                                    Платформа: <b>{{ $ad->ad_platform }}</b>
                                                </li>
                                                <li>
                                                    Статус: <b>{{ $ad->presentApproved() }}</b>
                                                </li>
                                                <li class="text-muted">
                                                    Синхронизирован:
                                                    <br>
                                                    {{ $ad->updated_at }}
                                                </li>
                                            </ul>
                                            <hr>
                                            Заметка: {{ $ad->note ?? '-'}}
                                        </div>
                                        <div class="card-footer">
                                            <form action="{{ route('ads.destroy', $ad) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                @if($ad->note)
                                                    <a href="{{ route('ads.edit', $ad) }}"
                                                       class="btn btn-sm btn-primary">
                                                        Изменить заметку
                                                    </a>
                                                @else
                                                    <a href="{{ route('ads.edit', $ad) }}"
                                                       class="btn btn-sm btn-success">
                                                        Добавить заметку
                                                    </a>
                                                @endif
                                                <button class="btn btn-sm btn-danger float-right">
                                                    Архивировать
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>
                                    Объявления синхронизируются, попробуйте обновить страницу через пару минут
                                </p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
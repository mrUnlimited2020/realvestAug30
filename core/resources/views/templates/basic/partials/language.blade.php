@if ($general->multi_language)
    @php
        $language       = App\Models\Language::all();
        $activeLanguage = $language->where('code', config('app.locale'))->first();
    @endphp
    <div class="custom--dropdown">
        <div class="custom--dropdown__selected dropdown-list__item">
            <div>
                <div class="thumb">
                    <img src="{{ getImage(getFilePath('language') . '/' . @$activeLanguage->image, getFileSize('language')) }}"
                        alt="image">
                </div>
            </div>
            <span class="text">{{ __(@$activeLanguage->name) }}</span>
            <span class="icon"><i class="fas fa-angle-down"></i></span>

        </div>
        <ul class="dropdown-list">
            @foreach ($language as $item)
                @if (@$item->id != @$activeLanguage->id)
                    <li class="dropdown-list__item langSel" data-value="{{ $item->code }}">
                        <div>
                            <div class="thumb">
                                <img src="{{ getImage(getFilePath('language') . '/' . @$item->image, getFileSize('language')) }}" alt="image">
                            </div>
                        </div>
                        <span class="text">{{ __($item->name) }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif

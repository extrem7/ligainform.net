<div class="search-box">
    <form action="{{home_url('/')}}" class="d-flex align-items-center">
        <div class="search-inner-box">
            <button type="submit" class="icon search-submit">
                <img src="{{asset('img/icons/search-white.svg')}}" alt="search">
            </button>
            <input type="text" class="control-form" name="s" placeholder="Введите ваш запрос" minlength="3" required>
        </div>
    </form>
    <button class="icon close-btn"><img src="{{asset('img/icons/close.svg')}}" alt="close-search"></button>
</div>
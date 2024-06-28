<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        .nav-item.active {
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        .nav-item.active>a.nav-link {
            color: white;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @livewireStyles

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function get_select2_ajax_options(url, extraFilter = null) {
            return {
                url: url,
                dataType: 'json',
                type: 'get',
                delay: 250,
                data: function(params) {
                    return get_select2_search_term(params, extraFilter);
                },
                processResults: function(data, params) {
                    return {
                        results: data.items,
                        'pagination': {
                            'more': data.more
                        }
                    };
                },
                cache: true,
            };
        }

        function get_select2_search_term(params, extraFilter) {
            var search_term = {
                q: params.term || '', // search term
                page_limit: 10,
                page: params.page || 1
            };

            Object.assign(search_term, extraFilter)

            return search_term;
        }

        const setSelect2MultiDimensional = (
            param, identityData, valueData,
            identityKeyname = 'id', valueKeyname = 'val',
        ) => {
            if (!param) return
            $(param).select2({
                multiple: true,
            });

            const combinedData = identityData.reduce((accumulator, currentValue, index) => {
                return [...accumulator, {
                    [identityKeyname]: currentValue,
                    [valueKeyname]: valueData[index],
                }]
            }, [])

            $(param).select2('data', combinedData);

            const selectedValue = combinedData.map(item => {
                const newOption = new Option(item[valueKeyname], item[identityKeyname], true, true);
                $(param).append(newOption);
                return item[identityKeyname];
            });

            $(param).val(selectedValue);
        }
    </script>
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    @livewire('navbar')
    <div class="container mt-5">
        {{ $slot }}
    </div>

    @livewireScripts

</body>

</html>

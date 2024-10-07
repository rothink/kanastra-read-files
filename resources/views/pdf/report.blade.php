<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <style>
        h4 {
            margin: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
        }

        .margin-top {
            margin-top: 1.25rem;
        }

        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241 245 249);
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        table.products {
            font-size: 0.875rem;
        }

        table.products tr {
            background-color: rgb(96 165 250);
        }

        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }

        table tr.items {
            background-color: rgb(241 245 249);
        }

        table tr.items td {
            padding: 0.5rem;
        }

        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.875rem;
        }

    </style>

</head>
<body>
<table class="w-full">
    <tr>
        <td class="w-half">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAk1BMVEX////LBgbygYHKAADcfHzPMTHUU1PXZWXfiorMFxfHAAD0hobUKyvknZ3gT0/kn5/WXl7jk5PxeXn71tbgj4/UQED54+P719fWTU366en++Pjwy8vzjIz2r6/329v87+/wxMTccHDVV1fuvLzpqKjiYWHbRUXXNjblXV3iVVXRIiLudHTihobrsrLSOTnfe3vNEhKAWPopAAAE6ElEQVR4nO3daXuaQBSGYfC4UoghcSUtuCRdbGL8/7+uKhBBiAxmPDND3+cbF2q9AziDVLUshBBCCCGEEEIIIYQQQggh0wu91bYjoZfvh6aqOYXWrkNyumsdenhULcoXzRyy5UR33zQkPm5k+U7C1oNGO2pI8oAnoUbEwJYIzAj12VHvZQKzQl2ITzL30bxQkx1V7ibMC7XYipHcTXgm1IG4cKQCz4Ua7Ki+3E1YEKontm8tVL6j3l6omsggVLyjcgjVbkUWoVIij1AlkUmo8FjkEqrbimxCZUQ+oaodlVGoaCtyCtUQWYVKiLxCFURmoQIit5CfyC5kJ/ILuYkKhMxEFUJeohIhK1GNkJMoXfhTSMhIVCXkI0oXbgWFbETpwoEgkI0oW2iTsJCJKF/4ohlRvvCX6IHIRJQutOlBXMhBvIGw1kb8YaDQpt/iREOF9CJMNFO4N/5pic5sDBXatPn9t/VNoJapwv2eSoONW93m1VRhjBSobbBQ7M8AIYQQQgghhBBCCCGEl4TnM+RPV1Xcr+QmeghpM/xo1F7tMs+TqJ+s8EbLcUE/Gp7Vv0RUKPTyN4veZukTpfvcmtDbZghnK4+t9BT6hVsuBvQJYu2eNrDJQmseQ0oQwTL9TIPZQmty3B3LENa7Y6owmO8L0hv7OeE8Ck6P0/1sF7asmdbC3uHDs24vjJeOHyFKEW/7FSsvSh5nTrld+G3WTRtrOlokwsPf/zAgTOLFTkbox4PdOnmgfk7YFhsONREeFlfx4ntOeFzjJMR57iAVnSrpI9zEi15BaJOdHI3dpgpt5zleHpotHMeLryXCdN1TXihyFGokTLfTrERoO/HyJPtCOxJ7odFAeHd8kk46ylGpMB4xguxKa5I072n+WurvNgN3mY4I6+yOeBKGRf6poebCXIF7hdAzSdjODeonYTIdMF/YjmfXRWE8IEam76WTdAJdGC0oXg6zu3Dw9Bg37RohDKK37sf3uxSEy3h5kRsPnTTdR4vn5XLZ67qUeaKFOc0iXu6bOafZFkft83lpMqWxxmYKS07uzs4t0hOr0NBzi0vCw8mxM54nD7Q8Oz9sgHDhdrrtRfo4ITVPaAWZt2ksN/8+TTOE2dJRr6nC6GNYb6jweVd4z9sA4UhUOPU3JdctDBDao31+2Vqitj+Ke+1t97MdKq68eL1JD6F94S0IoeuHYkBcA4YQQgghhBBCCCGE8L8Xln7C5Yq0FVJn1ZWStu95U1B9X6Hedb1uQbL+AW2vPUkTanv9EELhmi/U9ziU9Vp6eUqhcjwc96RU8aX2mNPcUsgThBBC+H8Lb/TiqY+QVqP+VQ1qEU2cta0bL6z3sy4QSgjC2jVf+GSMcF5939Lq/byS0v+LMbguY0b8q+c0tYCYl0IIIYTNFpJTmYy/jcIRv1d9Vxk/nahQ+Fx913rzM+2EQwgh1F7Y/OPQq76r4ULyvapco0cLoZOnrwMxa4MQQgghhBBCCOUk40T9K8Kyb4mRW71LRdJLv1TjhkVSppfXRhRVP8Wvdvmbqm4tFHjD68tNFW5EIpbfJVO4EVk2oWUFO1VE2sn6b7oVhYr2U6KQB7gnyng/oj5wM+UCHr65Q8pFiFo+Z8YwUGRad5xrL2tfleOuq5+U5MLh/bbD03blsR2BCCGEEEIIIYQQQgghhBBCN+sfypGbO0fYqnMAAAAASUVORK5CYII=" alt="laravel daily" width="200"/>
        </td>
        <td class="w-half">
            <h2>Report - view</h2>
        </td>
    </tr>
</table>

<div class="margin-top">
    <table class="products">
        <tr>
            <th>id</th>
            <th>Autor</th>
            <th>Livros</th>
            <th>Assuntos</th>
        </tr>

        @foreach($data as $item)
            <tr class="items">
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->nome }}
                </td>
                <td>
                    {{$item->livros}}
                </td>
                <td>
                    {{$item->assuntos}}
                </td>
            </tr>
        @endforeach

    </table>
</div>

<div class="total">
    today: {{$today}}
</div>

<div class="footer margin-top">
    <div>Thank you</div>
    <div>&copy; Rodrigo Araujo</div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MP-API</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
            html, * {
                margin: 0;
                padding: 0;
            }
            body {
                background-color: #292929;
                color: #e9e9e9;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }
            .vmp {

            }
        </style>

        <!-- Styles / Scripts -->
        {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif --}}

    </head>
    <body>
        <div class="vmp">
            <div id="walletBrick_container"></div>
        </div>

        {{-- <script src="https://sdk.mercadopago.com/js/v2"></script>
        <script>
            // Configure sua chave pública do Mercado Pago
            const mp = new MercadoPago("{{ env("MP_PUBLIC_KEY") }}", {
                locale: 'es-MX'
            });

            const bricksBuilder = mp.bricks();

            fetch("{{ route('checkout.create') }}")
            .then(res => res.json())
            .then(data => {
                const preferenceId = data.preference_id;
                renderWalletBrick(bricksBuilder, preferenceId);
            });

            const renderWalletBrick = async (bricksBuilder, preferenceId) => {
                await bricksBuilder.create("wallet", "walletBrick_container", {
                    initialization: {
                        preferenceId: preferenceId,
                    },
                });
            };
        </script> --}}
    </body>
</html>

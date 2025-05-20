<x-mail::message>
    # ✅ Narudžbina uspešno kreirana!

    Hvala Vam na poverenju, **{{ $order->name }}**.
    Vaša narudžbina je primljena i obrađena pod brojem: **#{{ $order->id }}**

    ---

    ## 🧾 Detalji narudžbine

    - 👤 **Kupac:** {{ $order->name }}
    - 💳 **Ukupan iznos:** {{ number_format($order->total_price, 2, ',', '.') }} $
    - 📬 **Adresa dostave:** {{ $order->address }}
    - 📧 **Email:** {{ $order->email }}

    ---

    <x-mail::button :url="url('/orders/' . $order->id)">
        📦 Pogledaj svoju narudžbinu
    </x-mail::button>

    Ukoliko imate bilo kakva pitanja, slobodno nas kontaktirajte.

    Hvala što kupujete kod nas!
    **{{ config('app.name') }}**

</x-mail::message>
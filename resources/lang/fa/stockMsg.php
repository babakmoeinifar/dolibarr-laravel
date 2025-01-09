<?php

return [
    'esop_expire'                   => 'قرارداد «:name» منقضی شد.',
    'trade_done'                    => 'انتقال با موفقیت انجام شد',
    'trade_failed'                  => 'خطایی در انتقال سهام رخ داد',
    'vest_failed'                   => 'خطایی در تحقق سهام رخ داد',

    'sold-out-stock'                => ':tokens_quantity مثقال :symbol به ارزش :total_amount تومان در معامله :tradeId فروختید.',
    'bought-stock'                  => ':tokens_quantity مثقال :symbol به ارزش :total_amount تومان در معامله :tradeId خریدید.',
    'expired-order'                 => 'سفارش :orderId شما منقضی شد.',
    'buyer-should-pay-for-trade'    => 'معامله‌ی :pendingTradeId در آستانه‌ی پرداخت است. قبل از منقضی شدن پرداخت فرمایید.'.PHP_EOL.' انقضا: :expires_at',
    'deposit-ready-to-approve'      => 'مبلغ :total_amount تومان بابت فروش :token_quantity مثقال :symbol به حساب شما واریز شد؛ تایید یا رد کنید.',
    'seller-approved-deposit'       => 'فروشنده واریزی شما بابت معامله‌ی در آستانه‌ی پرداخت :pendingTradeId را تایید کرد.',
    'seller-rejected-deposit'       => ':sellerName واریزی :buyerName بابت معامله‌ی در آستانه‌ی پرداخت :pendingTradeId را رد کرد. اگر انتظار بازنگری دارید با مدیر بازار ارتباط بگیرید.',
    'expired-pending-trade-seller'  => 'سفارش در آستانه پرداخت :pendingTradeId منقضی شد.',
    'expired-pending-trade-buyer'   => 'معامله‌ی در آستانه‌ی پرداخت :pendingTradeId به خاطر عدم واکنش فروشنده منقضی شد. پیگیری عودت وجه یا انتقال سهام توسط px در حال پیگیری است.',
    'expired-pending-trade-admin'   => 'خریدار مدعی پرداخت شده اما فروشنده واکنشی نشان نداده و معامله‌ی در آستانه‌ی پرداخت :pendingTradeId منقضی شده. پیگیری بفرمایید.',
    'order-submitted'               => 'سفارش ثبت شد.',
    'order-removed'                 => 'سفارش حذف شد.',
    'bank-account-number-required'  => 'شماره حساب بانکی برای شما ثبت نشده است.',
    'stock-symbol-is-closed'        => 'نماد معاملاتی بسته است.',
    'market-is-closed'              => 'بازار تعطیل است.',
    'not-sufficent-mesghal'         => 'تعداد مثقال شما برای فروش کافی نیست.',
    'not-enough-quantity-mesghal'   => 'تعداد مثقال نامعتبر است.',
    'expired-pending-trade'         => 'این معامله منقضی شده است!',
    'payment-deadline-reached'      => 'payment deadline reached',
    'penalty-note-for-buyer'        => 'جریمه بابت عدم پرداخت معامله سهام در موعد مقرر',

    'do-you-delete-order'           => 'سفارشو حذف می‌کنید؟',
    'your-payment-submitted'        => 'پرداخت شما ثبت شد. منتظر تایید توسط فروشنده باشید.',
    'did-you-get-money'             => 'پول به حساب‌تون واریز شده؟',
    'do-you-confirm-not-payemnt'    => 'مطمئنید که پول به حساب‌تون واریز نشده؟',

    'approved-by-market-broker'     => 'مدیر بازار واریزی شما در بخش معاملات سهام را تایید کرد.',
    'rejected-by-market-broker'     => "مدیربازار واریزی :buyerName در بخش معاملات سهام را به شماره سفارش :pendingTradeId تایید نکرد.",
    'stock_payment_rejected_decline'=> "it's not rejectable because: no payment assertion, or seller rejected before",
    'terms_accepted'                => 'شرایط و قوانین معاملات سهام توسط شما تایید شد.',
    'buyer_hasnt_asserted_any_payment'=> 'خریدار پرداختی نداشته است.',

    'flexible_price_hint' => 'این گزینه شانس جوش خوردن معامله رو می‌بره بالا. در حالت عادی، سیستم سفارشی که امکان جوش خوردن با سفارش شما رو نداره، نادیده می‌گیره. ولی وقتی این گزینه رو انتخاب می‌کنید، می‌پذیرید که قیمت سفارش‌تون ۳٪ نوسان داشته باشه تا سیستم برای جوش دادن معامله دستش مقداری باز باشه.'

];
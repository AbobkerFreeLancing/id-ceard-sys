<?php

namespace Packages\Enum\Transactions;

enum TransactionPurposeEnum: string
{
    case WalletTransfer = 'wallet_transfer';
    case VoucherRecharge = 'voucher_recharge';
    case BillPayment = 'bill_payment';
    case Fee = 'fee';
    case Refund = 'refund';
    case Adjustment = 'adjustment';
    case Cashback = 'cashback';
    case Penalty = 'penalty';
    case MobileRecharge = 'mobile_recharge';
    case BankDeposit = 'bank_deposit';
    case BankWithdrawal = 'bank_withdrawal';

    public function getLabel(): string
    {
        return match ($this) {
            self::WalletTransfer => __('backend.wallet_transfer'),
            self::VoucherRecharge => __('backend.voucher_recharge'),
            self::BillPayment => __('backend.bill_payment'),
            self::Fee => __('backend.fee_trnsx'),
            self::Refund => __('backend.refund'),
            self::Adjustment => __('backend.adjustment'),
            self::Cashback => __('backend.cashback'),
            self::Penalty => __('backend.penalty'),
            self::MobileRecharge => __('backend.mobile_recharge'),
            self::BankDeposit => __('backend.bank_deposit'),
            self::BankWithdrawal => __('backend.bank_withdrawal'),
            
        };
    }
}

<?php

namespace Packages\Accounting\Database\Seeders;

use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Accounting\Models\Account;
use Packages\Enum\Accounting\SafeBankTypeEnum;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    protected $acconts = [
        [
            // 01- Assets
            'name' => 'الأصول',
            'level_type' => AccountLevelTypeEnum::Group->value,
            'code' => '1',
            'slug' => 'assets',
            'is_editable' => false,
            'currency_id' => 1,
            'type' => 'debit',
            'children' => [
                [
                    'name' => 'الأصول المتداولة',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '11',
                    'slug' => 'current_assets',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'debit',
                    'children' => [
                        [
                            'name' => 'النقدية',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '111',
                            'slug' => 'acc_cash',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'debit',
                            'children' => [
                                [
                                    'name' => 'حساب الخزنة الافتراضي',
                                    'level_type' => AccountLevelTypeEnum::Sub->value,
                                    'code' => '1111',
                                    'slug' => 'safe_account',
                                    'is_editable' => true,
                                    'currency_id' => 1,
                                    'type' => 'debit',
                                    'account_type' => SafeBankTypeEnum::Safe->value,
                                ],
                                [
                                    'name' => 'حساب بنك أمدرمان الوططني',
                                    'level_type' => AccountLevelTypeEnum::Sub->value,
                                    'code' => '2222',
                                    'slug' => 'safe_account',
                                    'is_editable' => true,
                                    'currency_id' => 1,
                                    'type' => 'debit',
                                    'account_type' => SafeBankTypeEnum::Bank->value,
                                ],
                            ],
                        ],
                        [
                            'name' => 'العملاء',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '112',
                            'slug' => 'acc_customers',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'debit',
                        ],
                        [
                            'name' => 'أوراق القبض',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '113',
                            'slug' => 'notes_receivable',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'debit',
                            'children' => [
                                [
                                    'name' => 'شيكات تحت التحصيل',
                                    'level_type' => AccountLevelTypeEnum::Sub->value,
                                    'code' => '1131',
                                    'slug' => 'notes_receivable',
                                    'is_editable' => true,
                                    'currency_id' => 1,
                                    'type' => 'debit',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'الأصول غير المتداولة',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '12',
                    'slug' => 'fixed_assets',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'debit',
                    'children' => [
                        [
                            'name' => 'الأصول طويلة الأجل (ثابتة)',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '121',
                            'slug' => 'acc_long_term_assets',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'debit',
                            'children' => [
                                [
                                    'name' => 'المباني',
                                    'level_type' => AccountLevelTypeEnum::Group->value,
                                    'code' => '1211',
                                    'slug' => 'acc_buildings',
                                    'is_editable' => false,
                                    'currency_id' => 1,
                                    'type' => 'debit',
                                    'children' => [],
                                ],
                                [
                                    'name' => 'الآلات والمعدات',
                                    'level_type' => AccountLevelTypeEnum::Group->value,
                                    'code' => '1212',
                                    'slug' => 'acc_machinery',
                                    'is_editable' => false,
                                    'currency_id' => 1,
                                    'type' => 'debit',
                                    'children' => [],
                                ],
                                [
                                    'name' => 'السيارات',
                                    'level_type' => AccountLevelTypeEnum::Group->value,
                                    'code' => '1213',
                                    'slug' => 'acc_cars',
                                    'is_editable' => false,
                                    'currency_id' => 1,
                                    'type' => 'debit',
                                    'children' => [],
                                ],
                            ],
                        ],
                        [
                            'name' => 'الأصول غير الملموسة',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '122',
                            'slug' => 'intangible_assets',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'debit',
                            'children' => [
                                [
                                    'name' => 'براءات الاختراع',
                                    'level_type' => AccountLevelTypeEnum::Group->value,
                                    'code' => '1221',
                                    'slug' => 'acc_patents',
                                    'is_editable' => false,
                                    'currency_id' => 1,
                                    'type' => 'debit',
                                ],
                                [
                                    'name' => 'الشهرة',
                                    'level_type' => AccountLevelTypeEnum::Group->value,
                                    'code' => '1222',
                                    'slug' => 'acc_goodwill',
                                    'is_editable' => false,
                                    'currency_id' => 1,
                                    'type' => 'debit',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],

        // 02- Liabilities
        [
            'name' => 'الإلتزامات',
            'level_type' => AccountLevelTypeEnum::Group->value,
            'code' => '2',
            'slug' => 'liabilities',
            'is_editable' => false,
            'currency_id' => 1,
            'type' => 'credit',
            'children' => [
                [
                    'name' => 'الإلتزامات المتداولة',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '21',
                    'slug' => 'acc_current_liabilities',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'credit',
                    'children' => [
                        [
                            'name' => 'الموردون',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '211',
                            'slug' => 'acc_suppliers',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'credit',
                            'children' => [],
                        ],
                        [
                            'name' => 'القروض قصيرة الأجل',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '212',
                            'slug' => 'acc_short_term_loans',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'credit',
                            'children' => [],
                        ],
                    ],
                ],
                [
                    'name' => 'الإلتزامات غير المتداولة',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '22',
                    'slug' => 'acc_non_current_liabilities',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'credit',
                    'children' => [
                        [
                            'name' => 'القروض طويلة الأجل',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '221',
                            'slug' => 'acc_long_term_loans',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'credit',
                            'children' => [],
                        ],
                        [
                            'name' => 'المخصصات طويلة الأجل',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '222',
                            'slug' => 'acc_long_term_provisions',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'credit',
                            'children' => [],
                        ],
                        [
                            'name' => 'الالتزامات الضريبية المؤجلة',
                            'level_type' => AccountLevelTypeEnum::Group->value,
                            'code' => '223',
                            'slug' => 'acc_deferred_tax_liabilities',
                            'is_editable' => false,
                            'currency_id' => 1,
                            'type' => 'credit',
                            'children' => [],
                        ],
                    ],
                ],
                [
                    'name' => 'أوراق الدفع',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '23',
                    'slug' => 'payable_papers',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'credit',
                    'children' => [
                        [
                            'name' => 'شيكات واجبة الدفع',
                            'level_type' => AccountLevelTypeEnum::Sub->value,
                            'code' => '231',
                            'slug' => 'payable_papers',
                            'is_editable' => true,
                            'currency_id' => 1,
                            'type' => 'credit',
                        ],
                    ],
                ],
            ],
        ],

        // 03- Equity
        [
            'name' => 'حقوق الملكية',
            'level_type' => AccountLevelTypeEnum::Group->value,
            'code' => '3',
            'slug' => 'equity',
            'is_editable' => false,
            'currency_id' => 1,
            'type' => 'credit',
            'children' => [
                [
                    'name' => 'رأس المال',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '31',
                    'slug' => 'acc_capital',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'credit',
                ],
                [
                    'name' => 'الأرباح المحتجزة',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '32',
                    'slug' => 'acc_retained_earnings',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'credit',
                ],
                [
                    'name' => 'الاحتياطات',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '33',
                    'slug' => 'acc_reserves',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'credit',
                ],
            ],
        ],

        // 04- Revenues
        [
            'name' => 'الإيرادات',
            'level_type' => AccountLevelTypeEnum::Group->value,
            'code' => '4',
            'slug' => 'revenues',
            'is_editable' => false,
            'currency_id' => 1,
            'type' => 'credit',
            'children' => [
                [
                    'name' => 'إيرادات المبيعات',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '41',
                    'slug' => 'acc_sales_revenue',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'credit',
                    'children' => [
                        [
                            'name' => 'إيراد المبيعات',
                            'level_type' => AccountLevelTypeEnum::Sub->value,
                            'code' => '411',
                            'slug' => 'acc_sales',
                            'is_editable' => true,
                            'currency_id' => 1,
                            'type' => 'credit',
                        ],
                    ],
                ],
                [
                    'name' => 'إيرادات متنوعة',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '42',
                    'slug' => 'acc_service_revenue',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'credit',
                    'children' => [],
                ],
            ],
        ],

        // 05- Expenses
        [
            'name' => 'المصروفات',
            'level_type' => AccountLevelTypeEnum::Group->value,
            'code' => '5',
            'slug' => 'expenses',
            'is_editable' => false,
            'currency_id' => 1,
            'type' => 'debit',
            'children' => [
                [
                    'name' => 'المصروفات التشغيلية',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '51',
                    'slug' => 'acc_operating_expenses',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'debit',
                ],
                [
                    'name' => 'المصروفات العمومية والإدارية',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '52',
                    'slug' => 'acc_administrative_expenses',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'debit',
                    'children' => [
                        [
                            'name' => 'خدمات الكهرباء',
                            'level_type' => AccountLevelTypeEnum::Sub->value,
                            'code' => '521',
                            'slug' => 'acc_exps',
                            'is_editable' => true,
                            'currency_id' => 1,
                            'type' => 'debit',
                        ],
                        [
                            'name' => 'الايجار',
                            'level_type' => AccountLevelTypeEnum::Sub->value,
                            'code' => '522',
                            'slug' => 'acc_exps',
                            'is_editable' => true,
                            'currency_id' => 1,
                            'type' => 'debit',
                        ],
                        [
                            'name' => 'مستهلكات',
                            'level_type' => AccountLevelTypeEnum::Sub->value,
                            'code' => '523',
                            'slug' => 'acc_exps',
                            'is_editable' => true,
                            'currency_id' => 1,
                            'type' => 'debit',
                        ],
                        [
                            'name' => 'دعاية وإعلان',
                            'level_type' => AccountLevelTypeEnum::Sub->value,
                            'code' => '524',
                            'slug' => 'acc_exps',
                            'is_editable' => true,
                            'currency_id' => 1,
                            'type' => 'debit',
                        ],
                    ],
                ],
                [
                    'name' => 'مردودات المبيعات',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '53',
                    'slug' => 'acc_sales_returns',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'debit',
                    'children' => [
                        [
                            'name' => 'حساب مردود المبيعات',
                            'level_type' => AccountLevelTypeEnum::Sub->value,
                            'code' => '531',
                            'slug' => 'acc_sales_returns',
                            'is_editable' => true,
                            'currency_id' => 1,
                            'type' => 'debit',
                        ],
                    ],
                ],
                [
                    'name' => 'حسابات المشتريات',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '54',
                    'slug' => 'acc_purchases',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'debit',
                    'children' => [
                        [
                            'name' => 'المشتريات',
                            'level_type' => AccountLevelTypeEnum::Sub->value,
                            'code' => '541',
                            'slug' => 'acc_purchases',
                            'is_editable' => true,
                            'currency_id' => 1,
                            'type' => 'debit',
                        ],
                    ],
                ],
                [
                    'name' => 'حسابات مردودات المشتريات',
                    'level_type' => AccountLevelTypeEnum::Group->value,
                    'code' => '55',
                    'slug' => 'acc_purchases_returns',
                    'is_editable' => false,
                    'currency_id' => 1,
                    'type' => 'credit',
                    'children' => [
                        [
                            'name' => 'مردود المشتريات',
                            'level_type' => AccountLevelTypeEnum::Sub->value,
                            'code' => '551',
                            'slug' => 'acc_purchases_returns',
                            'is_editable' => true,
                            'currency_id' => 1,
                            'type' => 'credit',
                        ],
                    ],
                ],
            ],
        ],
    ];

    public function run()
    {
        foreach ($this->acconts as $accountData) {
            $this->createAccount($accountData);
        }
    }

    protected function createAccount(array $accountData, $parentId = null)
    {
        $children = $accountData['children'] ?? [];
        unset($accountData['children']); // Remove children to avoid mass assignment issues

        $account = Account::create(
            array_merge($accountData, [
                'parent_id' => $parentId,
            ]),
        );

        foreach ($children as $childData) {
            $this->createAccount($childData, $account->id);
        }
    }
}

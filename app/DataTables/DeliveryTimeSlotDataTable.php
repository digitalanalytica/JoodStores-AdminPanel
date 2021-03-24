<?php

namespace App\DataTables;
use App\DeliveryTimeSlot;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Barryvdh\DomPDF\Facade as PDF;

class DeliveryTimeSlotDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable
            ->editColumn('updated_at', function ($deliverytimeslot) {
                return getDateColumn($deliverytimeslot, 'updated_at');
            })
            ->editColumn('status', function ($deliverytimeslot) {
                return getBooleanColumn($deliverytimeslot, 'status');
            })
            ->addColumn('action', 'delivery_time_slots.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            [
                'data' => 'timeslot',
                'title' => trans('lang.delivery_time_slot_name'),

            ],

            [
                'data' => 'status',
                'title' => trans('lang.delivery_time_slot_status'),

            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.delivery_time_slot_updated_at'),
                'searchable' => false,
            ]
        ];
        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DeliveryTimeSlot $model)
    {
        if (auth()->user()->hasRole('admin')) {
            return $model->newQuery();
        }elseif (auth()->user()->hasRole('manager')){
            $markets = $model->join("discountables", "discountables.coupon_id", "=", "coupons.id")
                ->join("user_markets", "user_markets.market_id", "=", "discountables.discountable_id")
                ->where('discountable_type','App\\Models\\Market')
                ->where("user_markets.user_id",auth()->id())->select("coupons.*");

            $products = $model->join("discountables", "discountables.coupon_id", "=", "coupons.id")
                ->join("products", "products.id", "=", "discountables.discountable_id")
                ->where('discountable_type','App\\Models\\Product')
                ->join("user_markets", "user_markets.market_id", "=", "products.market_id")
                ->where("user_markets.user_id",auth()->id())
                ->select("coupons.*")
                ->union($markets);
            return $products;
        }else{
            $model->newQuery();
        }

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['title'=>trans('lang.actions'),'width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
            ->parameters(array_merge(
                config('datatables-buttons.parameters'), [
                    'language' => json_decode(
                        file_get_contents(base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                        ), true),
                    'order' => [ [5, 'desc'] ],
                ]
            ));
    }

    /**
     * Export PDF using DOMPDF
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));
        return $pdf->download($this->filename() . '.pdf');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'delivery_time_slot_datatable_' . time();
    }
}
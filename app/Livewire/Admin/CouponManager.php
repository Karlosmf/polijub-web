<?php

namespace App\Livewire\Admin;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class CouponManager extends Component
{
    use Toast;

    public bool $myModal = false;
    public bool $isEditing = false;

    public $couponId;

    public string $code = '';
    public string $type = 'percentage';
    public $value;
    public $product_id;
    public $user_id;
    public $starts_at;
    public $expires_at;
    public $max_uses;
    public bool $is_active = true;

    protected function rules()
    {
        return [
            'code' => 'required|min:3|unique:coupons,code,' . $this->couponId,
            'type' => 'required|in:percentage,fixed_product,fixed_amount',
            'value' => 'required_if:type,percentage,fixed_amount|nullable|numeric|min:0',
            'product_id' => 'required_if:type,fixed_product|nullable|exists:products,id',
            'user_id' => 'nullable|exists:users,id',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'max_uses' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ];
    }

    public function generateCode()
    {
        $this->code = strtoupper(Str::random(8));
    }

    public function save()
    {
        $this->validate();

        $data = [
            'code' => strtoupper($this->code),
            'type' => $this->type,
            'value' => in_array($this->type, ['percentage', 'fixed_amount']) ? $this->value : null,
            'product_id' => $this->type === 'fixed_product' ? $this->product_id : null,
            'user_id' => $this->user_id ?: null,
            'starts_at' => $this->starts_at ?: null,
            'expires_at' => $this->expires_at ?: null,
            'max_uses' => $this->max_uses ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            $coupon = Coupon::find($this->couponId);
            $coupon->update($data);
            $this->success('Cupón actualizado correctamente.');
        } else {
            Coupon::create($data);
            $this->success('Cupón creado correctamente.');
        }

        $this->myModal = false;
        $this->resetForm();
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $this->couponId = $coupon->id;
        $this->code = $coupon->code;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->product_id = $coupon->product_id;
        $this->user_id = $coupon->user_id;
        $this->starts_at = $coupon->starts_at?->format('Y-m-d\TH:i');
        $this->expires_at = $coupon->expires_at?->format('Y-m-d\TH:i');
        $this->max_uses = $coupon->max_uses;
        $this->is_active = $coupon->is_active;
        
        $this->isEditing = true;
        $this->myModal = true;
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->myModal = true;
    }

    public function delete($id)
    {
        Coupon::destroy($id);
        $this->success('Cupón eliminado.');
    }

    public function toggleActive($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update(['is_active' => !$coupon->is_active]);
        $this->success('Estado actualizado.');
    }

    public function resetForm()
    {
        $this->reset(['couponId', 'code', 'type', 'value', 'product_id', 'user_id', 'starts_at', 'expires_at', 'max_uses', 'is_active']);
        $this->type = 'percentage';
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        $coupons = Coupon::with(['product', 'user'])
            ->latest()
            ->get();

        $products = Product::where('is_active', true)->orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('livewire.admin.coupon-manager', [
            'coupons' => $coupons,
            'products' => $products,
            'users' => $users,
        ]);
    }
}

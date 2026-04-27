<?php
namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Order;
    use App\Models\OrderItem;
    use App\Models\Menu;
    use Illuminate\Support\Facades\DB;

    class OrderController extends Controller
    {
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'items' => 'required|array',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'name' => $request->name,
                'total_price' => 0
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);

                $price = $menu->price;
                $qty = $item['qty'];
                $subtotal = $price * $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $qty,
                    'price' => $price
                ]);

                $total += $subtotal;
            }

            $order->update([
                'total_price' => $total
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat',
                'data' => $order->load('items.menu')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat order'
            ], 500);
        }
    }
    }
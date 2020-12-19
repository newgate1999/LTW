<?php

class Cart
{
    public $items = null;
    public $totalPrice = 0;
    public $totalQuantity = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalQuantity = $oldCart->totalQuantity;
        }
    }

    public function addItem($item) {
        $itemInCart = ['quantity' => 0, 'price' => $item['price'], 'item' => $item];
        // Check if the cart already exists
        if ($this->items) {
            if (array_key_exists($item['id'], $this->items)) {
                $itemInCart = $this->items[$item['id']];
            }
        }
        $itemInCart['quantity']++;
        $itemInCart['price'] = $itemInCart['quantity'] * $item['price'];
        $this->items[$item['id']] = $itemInCart;
        $this->totalQuantity ++;
        $this->totalPrice += $item['price'];
    }

    public function removeItem($item)
    {
        if ($this->items) {
            if (array_key_exists($item['id'], $this->items)) {
                $itemInCart = $this->items[$item['id']];
                $itemInCart['quantity']--;
                $itemInCart['price'] = $itemInCart['quantity'] * $item['price'];
                $this->items[$item['id']] = $itemInCart;
                $this->totalQuantity--;
                $this->totalPrice -= $item['price'];

                if ($itemInCart['quantity'] == 0) {
                    unset($this->items[$item['id']]);
                }
            }
        }
    }

    public function removeItemFromArray($item)
    {
        if ($this->items) {
            if (array_key_exists($item['id'], $this->items)) {
                $itemInCart = $this->items[$item['id']];
                $this->totalQuantity -= $itemInCart['quantity'];
                $this->totalPrice -= $itemInCart['price'];
                unset($this->items[$item['id']]);
            }
        }
    }
}
?>

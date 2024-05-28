import { Component, OnDestroy, OnInit } from '@angular/core';
import { CartService } from '../services/cart.service';
import { CommonModule } from '@angular/common';
import { Cart } from '../models/cart';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-cart',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './cart.component.html',
  styleUrl: './cart.component.css',
})
export class CartComponent implements OnInit, OnDestroy {
  cartItems: Cart[] = [];
  private subscription!: Subscription;
  total: number = 0;
  get totalAmount() {
    this.total = 0;
    for (let order of this.cartItems) {
      if (order.product) {
        this.total += order.product.price * order.quantity;
      }
    }
    return this.total;
  }

  constructor(private cartService: CartService) {}
  ngOnInit(): void {
    this.subscription = this.cartService.getAllCartItems().subscribe(
      (data) => {
        this.cartItems = data.data;
      },
      (error) => {
        console.error('Error fetching cart items', error);
      }
    );
  }

  increaseQuantity(cart: Cart) {
    cart.quantity += 1;
    this.updateTotal();
  }

  decreaseQuantity(cart: Cart) {
    if (cart.quantity > 1) {
      cart.quantity -= 1;
      this.updateTotal();
    }
  }

  updateTotal() {
    this.total = this.cartItems.reduce((sum, item) => {
      if (item.product) {
        return (sum ?? 0) + item.product.price * item.quantity;
      }
      return sum;
    }, 0);
  }

  ngOnDestroy() {
    if (this.subscription) {
      this.subscription.unsubscribe();
    }
  }
}

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
  // confermDelete(productId) {
  //   this.cartService.deleteCartItem(productId);

  //   this.students = this.students.filter((obj) => obj.id !== this.sts.id);
  //   this.cartService.deleteStudent(this.sts.id).subscribe({
  //     next: (data) => {},
  //   });
  // }

  ngOnDestroy() {
    if (this.subscription) {
      this.subscription.unsubscribe();
    }
  }
}

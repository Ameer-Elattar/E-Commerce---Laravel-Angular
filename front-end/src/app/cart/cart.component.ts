import { Component, OnInit } from '@angular/core';
import { CartService } from '../services/cart.service';
import { OrderDetails } from '../models/orderDetails';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-cart',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './cart.component.html',
  styleUrl: './cart.component.css',
})
export class CartComponent implements OnInit {
  orders: OrderDetails[] = [];
  total: number = 0;

  get totalAmount() {
    this.total = 0;
    for (let order of this.orders) {
      this.total += order.price * order.quantity;
    }
    return this.total;
  }

  constructor(private cartService: CartService) {}
  ngOnInit(): void {
    this.orders = this.cartService.generateRandomOrders(10);
  }
}

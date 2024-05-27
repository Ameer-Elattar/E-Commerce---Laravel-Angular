import { Injectable } from '@angular/core';
import { OrderDetails } from '../models/orderDetails';

@Injectable({
  providedIn: 'root',
})
export class CartService {
  constructor() {}
  generateRandomOrders(numOrders: number): OrderDetails[] {
    const orders: OrderDetails[] = [];

    for (let i = 0; i < numOrders; i++) {
      const order: OrderDetails = {
        id: i + 1,
        title: `Product ${i + 1}`,
        price: this.getRandomNumber(10, 100),
        quantity: this.getRandomNumber(1, 5),
        image: `https://picsum.photos/200/300?random=${i + 1}`,
      };

      orders.push(order);
    }

    return orders;
  }
  private getRandomNumber(min: number, max: number): number {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }
}

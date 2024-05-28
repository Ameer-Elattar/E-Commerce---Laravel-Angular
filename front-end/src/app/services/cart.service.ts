import { Injectable } from '@angular/core';
import { OrderDetails } from '../models/orderDetails';
import { Cart } from '../models/cart';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class CartService {
  constructor(public http: HttpClient) {}
  path: string = 'http://127.0.0.1:8000/api/carts';
  public cartArray: Cart[] = [];

  getAllCartItems() {
    return this.http.get<any>(this.path);
  }

  addCartItem(cart: any) {
    return this.http.post(this.path, cart);
  }
}

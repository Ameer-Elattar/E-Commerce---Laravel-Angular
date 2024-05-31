import { Injectable } from '@angular/core';
import { Cart } from '../models/cart';
import { HttpClient } from '@angular/common/http';
import { Observable, Subject, of } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class CartService {
  path: string = 'http://127.0.0.1:8000/api/carts/';
  public cartArray: Cart[] = [];
  public cartLength: number = 0;
  cartLengthSubject: Subject<any> = new Subject();
  role: string | null = localStorage.getItem('role');

  constructor(public http: HttpClient) {
    if (this.role) {
      if (this.role != 'admin') {
        this.getAllCartItems().subscribe((data) => {
          this.cartArray = data.data;
          this.cartLength = this.cartArray.length;
          this.cartLengthSubject.next(this.cartLength);
        });
      }
    }
  }
  getAllCartItems() {
    return this.http.get<any>(this.path);
  }
  getOneCart(id: number) {
    return this.http.get<Cart>(`${this.path}${id}`);
  }
  addCartItem(cart: any) {
    return this.http.post(this.path, cart);
  }
  updateCart(cart: Cart) {
    return this.http.patch(`${this.path}${cart.id}`, cart);
  }
  deleteCartItem(id: number) {
    const options = {
      body: { user_id: 1 },
    };
    return this.http.delete(`${this.path}${id}`, options);
  }

  pushIteminCart() {
    this.cartLength++;
    this.cartLengthSubject.next(this.cartLength);
  }
  removeItemfromCart() {
    this.cartLength--;
    this.cartLengthSubject.next(this.cartLength);
  }

  getIteminCart(): Observable<any> {
    return this.cartLengthSubject.asObservable();
  }
}

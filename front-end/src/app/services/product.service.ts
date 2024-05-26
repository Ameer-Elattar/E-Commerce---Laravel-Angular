import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Product } from '../models/product';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  private baseUrl = 'http://127.0.0.1:8000/api'; 
  
  constructor(private http: HttpClient) {} 

  getProducts(): Observable<Product[]> {
    return this.http.get<Product[]>(`${this.baseUrl}/products`);
  }


  getProductByName(title: string): Observable<Product> {
    return this.http.get<Product>(`${this.baseUrl}/products/title/${title}`);
  } 
}


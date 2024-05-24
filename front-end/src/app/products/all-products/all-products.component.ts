import { Component, OnInit, OnDestroy } from '@angular/core';
import { ProductService } from '../../services/product.service';
import { Product } from '../../models/product';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Subscription } from 'rxjs';
import { RouterLink } from '@angular/router';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { faEye, faCartPlus } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-all-products',
  templateUrl: './all-products.component.html',
  standalone:true,
  imports:[FormsModule,CommonModule,RouterLink,FontAwesomeModule],
  styleUrls: ['./all-products.component.css']
})

export class AllProductsComponent implements OnInit, OnDestroy {
  products: Product[] = [];
  faEye = faEye;
  faCartPlus = faCartPlus;
  private productsSubscription: Subscription | undefined;
  
  constructor(private productService: ProductService) {}

  ngOnInit() {
    this.productsSubscription = this.productService.getProducts()
      .subscribe(products => this.products = products);
  }

  ngOnDestroy() {
    if (this.productsSubscription) {
      this.productsSubscription.unsubscribe();
    }
  }

  
}



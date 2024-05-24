import { Component, OnInit, OnDestroy} from '@angular/core';
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
  pagedProducts: Product[] = [];
  currentPage = 1;
  pageSize = 16; 
  faEye = faEye;
  faCartPlus = faCartPlus;
  private productsSubscription: Subscription | undefined;

  constructor(private productService: ProductService) {}

  ngOnInit() {
    this.loadProducts();
  }


  loadProducts() {
    this.productsSubscription = this.productService.getProducts().subscribe(products => {
      this.products = products;
      this.setPage(1);
    });
  }

  setPage(page: number) {
    let startIndex: number;
    let endIndex: number;
  
    if (page === 1) {
      startIndex = 0;
    } else {
      startIndex = (page - 1) * this.pageSize;
    }
  
   endIndex = Math.min(startIndex + this.pageSize, this.products.length);
    this.pagedProducts = this.products.slice(startIndex, endIndex);
    this.currentPage = page;
  }
  

  nextPage() {
    if (this.currentPage * this.pageSize < this.products.length) {
      this.setPage(this.currentPage + 1);
    }
  }

  prevPage() {
    if (this.currentPage > 1) {
      this.setPage(this.currentPage - 1);
    }
  }

  ngOnDestroy() {
    if (this.productsSubscription) {
      this.productsSubscription.unsubscribe();
    }
  }
}



import { Component, OnInit, OnDestroy } from '@angular/core';
import { ProductService } from '../../services/product.service';
import { Product } from '../../models/product';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Subscription } from 'rxjs';
import { RouterLink } from '@angular/router';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { faEye, faCartPlus } from '@fortawesome/free-solid-svg-icons';
import { SpinnerComponent } from '../../layouts/spinner/spinner.component';
import { CartService } from '../../services/cart.service';
import { Cart } from '../../models/cart';

@Component({
  selector: 'app-all-products',
  templateUrl: './all-products.component.html',
  standalone: true,
  styleUrls: ['./all-products.component.css'],
  imports: [
    FormsModule,
    CommonModule,
    RouterLink,
    FontAwesomeModule,
    SpinnerComponent,
  ],
})
export class AllProductsComponent implements OnInit, OnDestroy {
  products: Product[] = [];
  pagedProducts: Product[] = [];
  cartItems: Cart[] = [];
  currentPage = 1;
  pageSize = 16;
  faEye = faEye;
  faCartPlus = faCartPlus;
  isLoading = true;
  private productsSubscription: Subscription | undefined;
  private cartSubscription!: Subscription;

  constructor(
    private productService: ProductService,
    private cartService: CartService
  ) {}

  ngOnInit() {
    this.loadProducts();
    this.loadCartItems();
  }

  loadProducts() {
    this.productsSubscription = this.productService
      .getProducts()
      .subscribe((products) => {
        this.products = products;
        this.setPage(1);
        this.isLoading = false;
      });
  }
  loadCartItems() {
    this.cartSubscription = this.cartService
      .getAllCartItems()
      .subscribe((cartItems) => {
        this.cartItems = cartItems.data;
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
  addToCart(product_id: number) {
    const CartItemExisting = this.cartItems.find(
      (obj) => obj.user_id === 1 && obj.product_id === product_id
    );
    if (CartItemExisting) {
      console.log('cart item already exists');
      return;
    }
    //TODO: Send only the product ID after finshing  backend authentication.
    const cartItem: Cart = {
      product_id,
      user_id: 1,
      quantity: 1,
      product: null,
    };
    this.cartSubscription = this.cartService.addCartItem(cartItem).subscribe(
      (data) => {
        this.cartItems.push(cartItem);
      },
      (error) => {
        console.error('Error Posting cart item', error);
      }
    );
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
    if (this.cartSubscription) {
      this.cartSubscription.unsubscribe();
    }
  }
}

import { CommonModule } from '@angular/common';
import { Component, HostListener, OnDestroy, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { faEye, faCartPlus } from '@fortawesome/free-solid-svg-icons';
import { AuthService } from '../../services/auth.service';
import { CartService } from '../../services/cart.service';
import { Subscription } from 'rxjs';
@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, RouterLink, FontAwesomeModule, FormsModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css',
})
export class NavbarComponent implements OnInit, OnDestroy {
  isNavbarTransparent: boolean = true;
  faCartPlus = faCartPlus;
  searchQuery: string = '';
  currentUser: any;
  cartItems: number = 0;
  private cartsubscriptions!: Subscription;
  constructor(
    private router: Router,
    private authService: AuthService,
    private cartService: CartService
  ) {}
  ngOnInit(): void {
    this.authService.getCurrentUser().subscribe((user) => {
      this.currentUser = user;
      console.log(this.currentUser);
    });
    this.getItemsCartNumber();
  }

  getItemsCartNumber() {
    this.cartsubscriptions = this.cartService
      .getIteminCart()
      .subscribe((cartItems) => {
        this.cartItems = cartItems;
      });
  }
  logout() {
    this.authService.logout();
  }
  @HostListener('window:scroll', [])
  onWindowScroll() {
    const yOffset = window.pageYOffset;
    if (yOffset > 50) {
      this.isNavbarTransparent = false;
    } else {
      this.isNavbarTransparent = true;
    }
  }

  onSearch() {
    if (this.searchQuery) {
      this.router.navigate(['/products/product-search'], {
        queryParams: { title: this.searchQuery },
      });
    }
  }
  ngOnDestroy(): void {
    if (this.cartsubscriptions) {
      this.cartsubscriptions.unsubscribe();
    }
  }
}

import { CommonModule } from '@angular/common';
import { Component, HostListener, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { faEye, faCartPlus } from '@fortawesome/free-solid-svg-icons';
import { AuthService } from '../../services/auth.service';
@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, RouterLink, FontAwesomeModule, FormsModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css',
})
export class NavbarComponent implements OnInit {
  isNavbarTransparent: boolean = true;
  faCartPlus = faCartPlus;
  searchQuery: string = '';
  currentUser: any;
  userRole:string|null=localStorage.getItem('role');

  constructor(private router: Router, private authService: AuthService) {}
  ngOnInit(): void {
    this.authService.getCurrentUser().subscribe((user) => {
      this.currentUser = user;
    });
    console.log(this.userRole);
    
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
}

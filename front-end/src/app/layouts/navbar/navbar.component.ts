import { CommonModule } from '@angular/common';
import { Component, HostListener } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { faEye, faCartPlus } from '@fortawesome/free-solid-svg-icons';
@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule,RouterLink , FontAwesomeModule,FormsModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css'
})
export class NavbarComponent {
  isNavbarTransparent: boolean = true;
  faCartPlus = faCartPlus;
  searchQuery: string = '';
  constructor(private router: Router) {}
  
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
      this.router.navigate(['/products/product-search'], { queryParams: { title: this.searchQuery } });
    }
  }

}

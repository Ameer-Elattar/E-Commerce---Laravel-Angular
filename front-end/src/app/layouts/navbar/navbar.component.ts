import { CommonModule } from '@angular/common';
import { Component, HostListener } from '@angular/core';
import { RouterLink } from '@angular/router';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { faEye, faCartPlus } from '@fortawesome/free-solid-svg-icons';
@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule,RouterLink , FontAwesomeModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css'
})
export class NavbarComponent {
  isNavbarTransparent: boolean = true;
  faCartPlus = faCartPlus;
  @HostListener('window:scroll', [])
  onWindowScroll() {
   
    const yOffset = window.pageYOffset;
    if (yOffset > 50) {
     
      this.isNavbarTransparent = false;
    } else {
      
      this.isNavbarTransparent = true;
    }
  }

}

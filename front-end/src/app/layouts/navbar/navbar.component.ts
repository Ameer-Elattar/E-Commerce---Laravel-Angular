import { CommonModule } from '@angular/common';
import { Component, HostListener } from '@angular/core';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css'
})
export class NavbarComponent {

  isNavbarTransparent: boolean = true;

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

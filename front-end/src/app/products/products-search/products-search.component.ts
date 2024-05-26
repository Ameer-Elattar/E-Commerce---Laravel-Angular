import { Component, OnDestroy } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ProductService } from '../../services/product.service';
import { Product } from '../../models/product';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Subscription } from 'rxjs';
import { CarouselComponent } from "../../homePage/carousel/carousel.component";
import { SpinnerComponent } from "../../layouts/spinner/spinner.component";
import { NoResultComponent } from "../../layouts/no-result/no-result.component";


@Component({
    selector: 'app-products-search',
    standalone: true,
    templateUrl: './products-search.component.html',
    styleUrl: './products-search.component.css',
    imports: [FormsModule, CommonModule, CarouselComponent, SpinnerComponent, NoResultComponent]
})


  export class ProductsSearchComponent implements OnDestroy {

    product: Product | null = null;
    isLoading = true;
    private routeSubscription: Subscription | null = null;
    private productSubscription: Subscription | null = null;

    
  constructor(private route: ActivatedRoute, private productService: ProductService) {}
  
  ngOnInit() {
    this.routeSubscription = this.route.queryParams.subscribe(params => {
        const title = params['title'];
        if (title) {
            this.productSubscription = this.productService.getProductByName(title).subscribe({
                next: (product: Product) => {
                    this.product = product;
                    this.isLoading = false;
                },
                error: (error: any) => {
                    console.error('Error fetching product:', error);
                    this.isLoading = false;
                }
            });
        }
    });
}

  
  
    ngOnDestroy() {
      if (this.routeSubscription) {
        this.routeSubscription.unsubscribe();
      }
      if (this.productSubscription) {
        this.productSubscription.unsubscribe();
      }
    }




  }
#include<iostream>
#include<math.h>
#include<stdlib.h>
#define MAX 20
#define k 4
using namespace std;
enum category{SHORT,TALL,AVERAGE};
class data{
	int x,y;
	category cat;
	public:
	void setd(int a,int b,category c){
		x=a;
		y=b;
		cat=c;
	}
	int getx(){return x;}
	int gety(){return y;}
	category getcat(){
		return cat;
	}
};//end of class
int dis(data d1,data d2)
{
	return sqrt(pow((d2.getx()-d1.getx()),2)+pow((d2.gety()-d1.gety()),2));
}
int main()
{
	do{
		int p,q; //input
		double a[MAX]; //store distances
		int b[k]; //to get min distances, used in calc
		int c[k]; //to store freq
		int indexOfminimumDistancePoint;
		for(int i=0;i<k;i++){ //initiLIZATION
			b[i]=-1;
			c[i]=0;
		} double min=1000;
		cout<<"Enter x,y(negative value to exit): ";
		cin>>p>>q;
		if((p < 0) | (q < 0))
			exit(0);
		data n; //data point to classify
		n.setd(p,q,SHORT);
		data d[MAX]; //training set

		d[0].setd(1,1,SHORT);
		d[1].setd(1,2,SHORT);
		d[2].setd(1,3,SHORT);
		d[3].setd(1,4,SHORT);
		d[4].setd(1,5,SHORT);
		d[5].setd(1,6,SHORT);
		d[6].setd(1,7,SHORT);
		d[7].setd(2,1,SHORT);
		d[8].setd(2,2,SHORT);
		d[9].setd(2,3,AVERAGE);
		d[10].setd(2,4,AVERAGE);
		d[11].setd(2,5,AVERAGE);
		d[12].setd(2,6,AVERAGE);
		d[13].setd(2,7,AVERAGE);
		d[14].setd(5,1,TALL);
		d[15].setd(5,2,TALL);
		d[16].setd(5,3,TALL);
		d[17].setd(5,4,TALL);
		d[18].setd(5,5,TALL);
		d[19].setd(5,6,TALL);
		for(int i=0;i<20;i++){
			a[i]=dis(n,d[i]);
			cout<<"\t\t"<<a[i]<<endl;
		}

			min=1000;
			for(int i=0;i<20;i++)
			{
					if((a[i]<min))
					{
						min=a[i];
						indexOfminimumDistancePoint=i;
					}

			}
			cout<<min<<endl;
			cout<<"index:"<<indexOfminimumDistancePoint<<endl;

		cout<<d[indexOfminimumDistancePoint].getcat()<<endl;

			switch (d[indexOfminimumDistancePoint].getcat())
			{
			case SHORT:

				cout<<"short"<<endl;
				break;
			case AVERAGE:

				cout<<"average"<<endl;
				break;
			case TALL:

				cout<<"tall"<<endl;
				break;
			}

	}while(true);
	return 0;
}

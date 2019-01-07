#include<iostream>
#include<math.h>
#include<stdlib.h>
#define MAX 20

using namespace std;
void reset(int *p,int size);

enum category{SHORT,AVERAGE,TALL};
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
};
void initialise(data *d);
double dis(data d1,data d2)
{
	return sqrt(pow((d2.getx()-d1.getx()),2)+pow((d2.gety()-d1.gety()),2));
}
int main()
{
	do{
		int p,q;
		double distance[MAX];
		int freqForMinValue[] ={0,0,0};
		double minimumDistance;
		cout<<"Enter x,y(negative value to exit): ";
		cin>>p>>q;
		if((p < 0) | (q < 0))
			exit(0);
		data n;
		n.setd(p,q,SHORT);
		data d[MAX];
        initialise(d);

		for(int i=0;i<20;i++){
			distance[i]=dis(n,d[i]);
			cout<<"\t\t"<<distance[i]<<endl;
		}

			minimumDistance=(double)INT_MAX;
			for(int i=0;i<20;i++)
			{
					if(distance[i]<minimumDistance)
					{
						minimumDistance=distance[i];
						reset(freqForMinValue,3);
						freqForMinValue[d[i].getcat()]=1;
					}
					else if(distance[i]==minimumDistance)
					{
						minimumDistance=distance[i];
						freqForMinValue[d[i].getcat()]++;
					}

			}
			cout<<"minimum distance="<<minimumDistance<<endl;

            int indexOfMaxFreq = 0;
			for(int i=1;i<3;i++){
                if(freqForMinValue[indexOfMaxFreq]<freqForMinValue[i])indexOfMaxFreq=i;
			}
            if(indexOfMaxFreq==0) cout<<"The point belongs to SHORT class"<<endl;
            else if(indexOfMaxFreq==1)cout<<"The point belongs to AVERAGE class"<<endl;
            else if(indexOfMaxFreq==2)cout<<"The point belongs to TALL class"<<endl;


		}while(true);
	return 0;
}

void initialise(data *d)
{
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

}
void reset(int *p,int size)
{
    for(int i=0;i<size;i++){
        p[i]=0;
    }
}

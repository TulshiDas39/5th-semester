package assignment2;

import java.util.ArrayList;
import java.util.Collections;

public class SortList {


	public void sort(ArrayList<Student> studentlist,Icomparer c){
		int length=studentlist.size();
		for(int i=0;i<length-1;i++)
		{
			for(int j=0;j<length-i-1;j++)
			{
				
				if(c.compare(studentlist.get(j), studentlist.get(j+1))==1){
					Collections.swap(studentlist, j+1, j);
					
				}
				  
			}
		}
		
	}
	
 }

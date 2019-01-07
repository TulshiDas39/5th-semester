package assignment2;

import java.security.cert.PKIXRevocationChecker.Option;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.Scanner;

public class Factory {

	public Factory(){
		ArrayList<Student> studentlist=new ArrayList<>();
		ArrayList<String>optionlist=new ArrayList<>();
		HashMap<String, Integer>hmap=new HashMap<>();
		studentlist.add(new Student("Joy sarker", "kurigram", 22, 3.59));
		studentlist.add(new Student("Joy sarker", "Narayangonj", 20, 3.59));
		studentlist.add(new Student("Saisab saha", "Khulna", 25, 3.63));
		studentlist.add(new Student("Tahmid khan", "Dhaka", 23, 3.98));
		studentlist.add(new Student("Toukir ahmed", "Shoriotpur", 27, 3.94));
	    hmap.put("name",1);
		hmap.put("district",2);
		hmap.put("age",3);
		hmap.put("cgpa",4);
		Scanner sc=new Scanner(System.in);
		String option=sc.next();
		optionlist.add(option);
		while(option.equals("quit")==false){
			option=sc.next();
			if(option.equals("quit")==false)
				optionlist.add(option);
		}
		
		Icomparer c=new StudentAttributeComparer(hmap.get(optionlist.get(optionlist.size()-1)));
		for(int i=optionlist.size()-1;i>=0;i--)
		{
			c=new StudentAttributeComparer(c,hmap.get(optionlist.get(i)));
		}
	   new SortList().sort(studentlist,c);
	   printSortedStudentList(studentlist);
		
	}
	public void printSortedStudentList(ArrayList<Student>studentlist)
	{
		for(int i=0;i<studentlist.size();i++)
		{
			System.out.println(studentlist.get(i).toString());
		}
	}
 }

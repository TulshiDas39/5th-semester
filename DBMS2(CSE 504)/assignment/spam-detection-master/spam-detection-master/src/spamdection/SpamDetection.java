package spamdection;
import java.io.*;
import java.lang.reflect.Array;
import java.util.*;


public class SpamDetection {
	
	public void SpamDection() {}
	
	
	/*
	 * Read from file:
	 * We have a file name, which contain many separate document.
	 * Each document is separated by "%%%%%%%%%%%%%%%%%%%%" (20 percentage signs)
	 * We want to read each document, and store each of them into array of word (string) or
	 * Using vector to store, each element is a word (string).
	 * We can have 50 Vectors (or arrays) to store those data.
	 * Then we scan each data to see if they have the same word that we want to detect spam.
	 * Implementation notes:
	 * - How to distinguish between each document by 20 percentage signs?
	 * - How to store each word in Vector (array) as a element?
	 * - How to compare every word in the Vector to our defined words of spam.
	 * - How to return a file corresponding to each document (as define in the project)
	 * ---- Pseudocode -----
	 * 
	 * 1. Let inputString <- name of file want to read.
	 * 2. Create a Object inputFile to read that inputString file.
	 * 3. Define START and END as the separate signs for each document.
	 * 4. Create a Vector to store word in the document.
	 * 5. Read file, start open a new Vector at the beginning. 
	 * 6. Store document in vector.
	 * 7. Close vector.
	 * 8. Call the function again, if it's not end of file. Repeat step 5.
	 * 9. Return a list of Vector.
	 * 10. Comparing defined word from defined dictionary of spam to the Vector.
	 * 11. Output a file.
	 * 12. Report successful or not.
	 */
	
	public static final String[] definedSpam = new String[] {"money","credit", "$", "sign",
		"offer", "order", "hot", "nude", "click", "card", "amateur", "pics","videos",
		"hardcore","teen","sex","limited","free","advertisement","mortgage","must-read","unsubscribe",
		"dollar","special","deposit","donation","register","lottery","guaranteed","exotic"};
	
	/*
	 * Read from file.
	 */
	public Vector<String> readFile(String s) throws IOException {
		String inputString = null;
		inputString = s;
		Vector <String> v = new Vector<String>();
		
		File inputFile = new File(inputString);
		BufferedReader buffReader = new BufferedReader(new FileReader(inputFile));

		int i;
		while((i = buffReader.read()) != -1) {
			String word = "";
			while(i != 10 && i !=32 && i != 46 && i !=44) {
				word = word + (char)i;
				if(word.startsWith("$")) {
					word = "$";
				}
				i = buffReader.read();
			}
			word.toLowerCase();
			v.add(word);
	
		}

		buffReader.close();
		return v;
		
	}

	/*
	 * Get number of line in file
	 */
	
	public int getLine(File f) throws IOException {
		BufferedReader buffReader = new BufferedReader(new FileReader(f));
		int numberOfLine = 0;
		while(buffReader.readLine() != null) {
			numberOfLine ++;
		}
		buffReader.close();
		return numberOfLine;
	}
	
	
	
	/*
	 * This will read the Training or Test file.
	 * Return a List of Array where each array is vocabulary V (consist of 30 terms)
	 */
	public List readTrainingFile(String s) throws IOException {
		String inputString = null;
		inputString = s;
		List<int[]> l = new ArrayList<int[]>();
		
		File inputFile = new File(inputString);
		BufferedReader buffReader = new BufferedReader(new FileReader(inputFile));
		int numberOfLine = getLine(inputFile);
		
		int j = 0;
		int k = 0;
		while(k <= 29) {		// Since we know the file has 30 lines.
							// We can improve this by create a function to get #lines.
			int[] aTemp = new int[30];
			Vector v = new Vector();
			//j = i;
			int count = 0;
			while((j = buffReader.read()) != 10 ) {
				String word = "";
				while(j != 32) {
					word = word + (char)j;
					j = buffReader.read();
				}
				if(word != "") {				
					aTemp[count] = Integer.parseInt(word);
					count++;
				}			
			}
			l.add(aTemp);
			k ++;
			
			//j = buffReader.read();
		}
		return l;
	}
	
	
	/*
	 * Find the number of training document in class c in which
	 * ti occurred at least once
	 * Note: this function will use the List from readTrainingFile.
	 * 
	 */
	
	public int[] occurranceTermInDocument(List l) {
		int[] aTemp = new int[30]; // at each position it will contain number of occurrences.
		int[] aOccurrenceTerms = new int[30];
		for(int i = 0; i < 30; i ++) {
			for(int j = 0; j < l.size(); j ++) {
				aTemp = (int[])l.get(j);
				if(aTemp[i] != 0) {
					aOccurrenceTerms[i]++;
				}
			}
		}
		return aOccurrenceTerms;
	}
	
	/*
	 * Array of probability of 30 training terms.
	 * Input: array of occurrence term in the training document.
	 * Output: array of probability of train naive bayes.
	 * Note that: for each probability from this array, it show how each term will have chance to appear in the testing document.
	 * This is training array of each terms. It says that, if a word appears in
	 * a document has Probability higher than the one in this array, then that document is a spam, and vice versa. 
	 */
	public float[] ProbabilityTrainBaiveBayes(int[] aOccurTerms) {
		float[] aPr = new float[30];
		for(int i = 0; i < aOccurTerms.length; i ++) {
			aPr[i] = (float)(aOccurTerms[i]+1)/(30+1);
		}
		return aPr;
	}
	
	
	/*
	 * Print the array of float.
	 */
	public void printFloatArray(float[] afloat) {
		for(int i = 0; i < afloat.length; i ++){
			System.out.print(afloat[i] + "  ");
		}
		System.out.println();
		
	}
	
	
	/*
	 * This function will generate an array which will store a result of test data.
	 * after calculate the value of [logP(c) + SUM(logP(ti|C)]
	 * 
	 */
	public float[] classifyTestData(List l) {
		float[] result = new float[20];
		int[] aTemp = new int[30];
		float[] fTemp = new float[30];
		float logPc = (float) Math.log(1/2);
		float fsum = 0;
		for(int i = 0; i < l.size(); i ++) {
			aTemp = (int[]) l.get(i);
			fTemp = ProbabilityTrainBaiveBayes(aTemp);
			for(int j = 0; j < fTemp.length; j ++) {
				fsum = fsum + fTemp[j];
			}
			result[i] = fsum + logPc;
		}
		return result;
		
	}
	
	
	
	/*
	 * 
	 */
	public Vector<String> readFile2(String s) throws IOException {
		String inputString = null;
		inputString = s;
		Vector <String> v = new Vector<String>();
		
		FileInputStream fis = new FileInputStream(inputString);
		DataInputStream dis = new DataInputStream(fis);
		
		
		int NumberofLineInput = 0;
		
		int i;
		while((i = dis.read()) != -1) {
			String word = "";
			while(i != 10 && i !=32 && i != 46 && i !=44) {
				word = word + (char)i;
				i = dis.read();
			}
			word.toLowerCase();
			v.add(word);
			
			NumberofLineInput++;

			System.out.println ("Line: "+ NumberofLineInput + "  Char:  " + i + "   Corresponding to   :"+ (char)i);
		}
		
		System.out.println("Number of line input: " + NumberofLineInput);
		System.out.println("First element test:   "+ v.elementAt(0) + " element test:  " + v.elementAt(1)
				+ " element test:  " + v.elementAt(2));
		
		fis.close();
		return v;
	}

	
	
	
	/*
	 * if string has the determination: "%%%%..."
	 * Then add 1 to result.
	 * Finally, return result.
	 * We will have number of determinator.
	 */
	
	public int[] getDeterminator(Vector<String> v) {
		int result = 0;
		int[] ArrayOfIndexDeterminator = new int[51];
		
		//char c = %;
		for(int i = 0; i < v.size(); i ++) {
			if(v.elementAt(i).startsWith("%%") == true){
				ArrayOfIndexDeterminator[result] = i;
				result++;
			}
		}
		return ArrayOfIndexDeterminator;
	}
	
	
	public void printVectorString(Vector<String> v){
		for(int i = 0; i < v.size(); i++) {
			System.out.println(v.elementAt(i));
		}
		
	}
	
	
	
	/*
	 * Create LinkedList of Vector.
	 * Where each vector store one document from the input file.
	 * Note for implementation:
	 * - Each document is separated by %%%... 
	 * Note
	 */
	//public LinkedList<Vector> l = new LinkedList<Vector>();
	
	
	public LinkedList<Vector> listOfDocumentVector(Vector<String> v){
		LinkedList<Vector> vList = new LinkedList<Vector>();	// Used to store 50 Vectors, where each vector is a document.
		int[] arrayOfIndexDeterminator = getDeterminator(v);	// Store 51 determinators.
		int arrayIndex;											// Used to count total number of documents need to scan.
		int i = 1;
		for(arrayIndex = 1; arrayIndex < 51; arrayIndex ++) {	// Assuming we know there are 50 documents.
			Vector<String> vTemp = new Vector<String>();
			while(i < arrayOfIndexDeterminator[arrayIndex]) { 	// Value i determines where to scan the element.
				vTemp.add(v.elementAt(i));
				i++;
			}
			vList.add(vTemp);
			i = arrayOfIndexDeterminator[arrayIndex]+1;
		}	
		return vList;
	}
	
	/*
	 *  ------- BIG PROBLEM HERE: IT SCAN ALL THE SPAMEXAMPLE FILE.
	 *  ------- THAT WHY'S WE HAVE THE RESULT OF BOTTOM DOCUMENT HAD ALL 1'S.
	 * ExtractVector:
	 * - Scan through the vector.
	 * - For each element in the defineSpam appears in the Vector. We update the aTemp array
	 * - 
	 */
	public int[] extractVector(Vector<String> v) {
		//Vector<String> v = new Vector<String>();
		int[] aTemp = new int[30];
		for(int i = 0; i < definedSpam.length; i ++) {
			for(int j = 0; j < v.size(); j ++) {
				if(v.elementAt(j).equalsIgnoreCase(definedSpam[i]) == true)
					aTemp[i] = 1;
			}
		}
		return aTemp;
	}
	
	
	/*
	 * - This method will extract the List of array.
	 * - Each array stores all elements from one document.
	 * - We expect to have 50 arrays.
	 * - So that, it will store totally 50 documents.
	 * - This method will call the function extractVector(Vector v).
	 * Input: a linkedlist of all array vector. 
	 */
	public List extractArrayList(LinkedList<Vector> l) {
		List aList = new ArrayList();	
		for(int i = 0; i < l.size(); i ++) {
			aList.add(extractVector(l.get(i)));
		}
		return aList;
	}
	
	
	/*
	 * ------ THIS IS USED FOR NAIVE BAYES OUTPUT ONLY -------
	 * Print elements in array:
	 * This method will get input from array, then it will print all the array out.
	 */
	public void printArrayBayes(int[] array) {
		for(int i = 0; i < array.length; i ++) {
			System.out.print(array[i] + "  ");
		}
		System.out.println();
	}
	
	
	/*
	 * ------ THIS IS USED FOR SVM_light OUTPUT ONLY -------
	 * Print elements in array:
	 * This method will get input from array, then it will print all the array out.
	 */
	public void printArraySVM1(int[] array) {
		System.out.print("1  ");
		for(int i = 0; i < array.length; i ++) {
			System.out.print((i+1) + ":<" +array[i] + ">  ");
		}
		System.out.println();
	}
	
	public void printArraySVM2(int[] array) {
		System.out.print("-1  ");
		for(int i = 0; i < array.length; i ++) {
			System.out.print((i+1) + ":<" + array[i] + ">  ");
		}
		System.out.println();
	}
	

	
	
	public static void main(String args[]) throws IOException {
		
		SpamDetection spd = new SpamDetection();
		Vector<String> v = new Vector<String>();
		LinkedList<Vector> l = new LinkedList<Vector>();
		List aList = new ArrayList();
		Vector<String> vTest = new Vector<String>();
		int[] aTemp = new int[30];
		
		List aListTest = new ArrayList();
		aListTest = spd.readTrainingFile("/Users/khoapham/Testcase/TestcaseHW4/SpamNaiveBayesTraining");
		aTemp = spd.occurranceTermInDocument(aListTest);
		spd.printFloatArray(spd.ProbabilityTrainBaiveBayes(aTemp));
		
		aListTest = spd.readTrainingFile("/Users/khoapham/Testcase/TestcaseHW4/NonSpamNaiveBayesTraining");
		aTemp = spd.occurranceTermInDocument(aListTest);
		spd.printFloatArray(spd.ProbabilityTrainBaiveBayes(aTemp));
		
		
		/*
		 * ----------- THIS IS OUTPUT FOR NAIVE BAYES CODE --------------
		 */
		// --------------------------------//
		v = spd.readFile("/Users/khoapham/Testcase/TestcaseHW4/SpamExamples.txt"); //Create Vector to store all strings from document.
		l = spd.listOfDocumentVector(v);	//Create LinkedList of Vectors		
		aList = spd.extractArrayList(l);	//Create a List where store all final arrays which will extract binary features and output to file.
		
		PrintStream pst = new PrintStream(new FileOutputStream(
				"/Users/khoapham/Testcase/TestcaseHW4/SpamNaiveBayes"));
		System.setOut(pst);
		/*
		 * This will output the extract binary features to file called "NaiveBayesTest"
		 */
		for(int i = 0; i < aList.size(); i++) {
			aTemp = (int[]) aList.get(i);
			spd.printArrayBayes(aTemp);
		}
		
		pst.close();
		
		// --------------------------------//
		
		v = spd.readFile("/Users/khoapham/Testcase/TestcaseHW4/non-spam-examples.txt");
		l = spd.listOfDocumentVector(v);	//Create LinkedList of Vectors		
		aList = spd.extractArrayList(l);
		PrintStream pst2 = new PrintStream(new FileOutputStream(
				"/Users/khoapham/Testcase/TestcaseHW4/NonSpamNaiveBayes"));
		System.setOut(pst2);
		/*
		 * This will output the extract binary features to file called "NonSpamNaiveBayesTest"
		 */
		for(int i = 0; i < aList.size(); i++) {
			aTemp = (int[]) aList.get(i);
			spd.printArrayBayes(aTemp);
		}
		pst2.close();	
		
		/*
		 * ---------- END OUTPUT FOR NAIVE BAYES CODE -----------------
		 */
		
		/*
		 * ----------- THIS IS OUTPUT FOR SVM_light FOR CLASS 1: SPAM--------------
		 */
		v = spd.readFile("/Users/khoapham/Testcase/TestcaseHW4/SpamExamples-copy.txt"); //Create Vector to store all strings from document.
		l = spd.listOfDocumentVector(v);	//Create LinkedList of Vectors		
		aList = spd.extractArrayList(l);	//Create a List where store all final arrays which will extract binary features and output to file.
		
		PrintStream pst3 = new PrintStream(new FileOutputStream(
				"/Users/khoapham/Testcase/TestcaseHW4/SVMSpam"));
		System.setOut(pst3);
		/*
		 * This will output the extract binary features to file called "NaiveBayesTest"
		 */
		for(int i = 0; i < aList.size(); i++) {
			aTemp = (int[]) aList.get(i);
			spd.printArraySVM1(aTemp);
		}
		
		pst3.close();
		
		/*
		 * ----------- THIS IS OUTPUT FOR SVM_light FOR CLASS -1: NON-SPAM--------------
		 */
		v = spd.readFile("/Users/khoapham/Testcase/TestcaseHW4/non-spam-examples-copy.txt");
		l = spd.listOfDocumentVector(v);	//Create LinkedList of Vectors		
		aList = spd.extractArrayList(l);
		PrintStream pst4 = new PrintStream(new FileOutputStream(
				"/Users/khoapham/Testcase/TestcaseHW4/SVMNonSpam"));
		System.setOut(pst4);
		/*
		 * This will output the extract binary features to file called "NonSpamNaiveBayesTest"
		 */
		for(int i = 0; i < aList.size(); i++) {
			aTemp = (int[]) aList.get(i);
			spd.printArraySVM2(aTemp);
		}
		pst4.close();
		
		
	}
	
}
